<?php 
/**********************************************************
 프로그램명 : class.fileUtil.php
 설명 : 파일관리용 클래스
 작성자 : 양찬우
 소속 : (주)비전아이티
 일자 : 18.06.12
 프로그램설명
 파일업로드/다운로드/삭제 등
 **프로그램이력**
 수정일          작업근거             유지보수담당
 '18.06.12       최초생성             양찬우
 **********************************************************/
class FileUtil {
    /**
     * 확장자를 제외한 파일명만 반환한다.
     * @param unknown $filename
     */
    static function filename($filename) {
        $checkname = mb_substr($filename, 0, mb_strrpos($filename, "."));
        $checkname = str_replace("/", "", $checkname);
        $checkname = str_replace("\\", "", $checkname);
        $checkname = str_replace("..", "", $checkname);
    
        return $checkname;
    }
    
    /**
     * 파일명에서 path 관련 문자를 제거한다.
     *
     * @param unknown $filename
     */
    static function safeFilename($filename) {
        $checkname = mb_substr($filename, 0, mb_strrpos($filename, "."));
        $extension = mb_substr(strrchr($filename, "."), 1);
    
        $checkname = str_replace("/", "", $checkname);
        $checkname = str_replace("\\", "", $checkname);
        $checkname = str_replace("..", "", $checkname);
    
        return $checkname.'.'.$extension;
    }
    
    /**
     * POST MAX 사이즈를 넘었는지 확인한다.
     * @return boolean
     */
    static function checkPostMaxSize() {
        $max_size = ini_get('post_max_size');
        $multiple = 1;
        $unit = mb_substr($max_size, -1);
    
        if($unit == 'M') {
            $multiple = 1024 * 1024;
        } else if($unit == 'K') {
            $multiple = 1024;
        } else if($unit == 'G') {
            $multiple = 1024 * 1024 * 1024;
        }
    
        $max_size = mb_substr($max_size, 0, strlen($max_size) - 1) * multiple;
    
        if($_SERVBER['REQUEST_METHOD'] == 'POST' && $_SERVER['CONTENT_LENGTH'] > $max_size) {
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * 파일 업로드 처리를 수행한다.
     *
     * @param array $fields
     * @param unknown $up_folder
     * @return boolean[][]|string[][]
     */
    static function uploadFileSingle(array $fields, $up_folder) {
                
        
        $uploaded = array();
        for($i = 0; $i < count($fields); $i++) {
            if(is_uploaded_file($_FILES[$fields[$i]]['tmp_name'])) {
                                  
                list($result, $ext, $error_msg) = FileUtil::checkFileSingle($fields[$i]);
                if($result) {
    
                    $nameonly = FileUtil::filename($_FILES[$fields[$i]]['name']);
    
                    $originalName = $nameonly . '.' . $ext;
    
                    $upFilename = md5(microtime(). $nameonly. $_SERVER['REMOTE_ADDR']) . '.' . $ext;
    
                    $tmp_name = $_FILES[$fields[$i]]['tmp_name'];
    
                    $saveFilename = "upfile_" . time() . $i . '_' . $upFilename;
    
                    $move_to = $up_folder . $saveFilename;
    
                    if(!move_uploaded_file($tmp_name, $move_to)) {
                        $error_msg[] = '파일의 업로드에 실패했습니다.';
                    }
                }
    
                if(count($error_msg) > 0) {
                    Util::error_back($error_msg[0]);
                } else {
                    $uploaded[$i] = array(true, $originalName, $saveFilename, $_FILES[$fields[$i]]['size'], $_FILES[$fields[$i]]['type']);
                }
            } else {
                $uploaded[$i] = array(false, '', '','' ,'' );
            }
        }
        return $uploaded;
    }
    
    static function uploadFileSingleOri(array $fields, $up_folder) {
        $uploaded = array();
        for($i = 0; $i < count($fields); $i++) {
            if(is_uploaded_file($_FILES[$fields[$i]]['tmp_name'])) {
    
                list($result, $ext, $error_msg) = FileUtil::checkFileSingle($fields[$i]);
    
                if($result) {
    
                    $nameonly = FileUtil::filename($_FILES[$fields[$i]]['name']);
    
                    $originalName = $nameonly . '.' . $ext;
    
//                     $upFilename = md5(microtime(). $nameonly. $_SERVER['REMOTE_ADDR']) . '.' . $ext;
    
                     $tmp_name = $_FILES[$fields[$i]]['tmp_name'];
    
//                     $saveFilename = "upfile_" . time() . $i . '_' . $upFilename;
    
                    $move_to = $up_folder . $originalName;
    
                    if(!move_uploaded_file($tmp_name, $move_to)) {
                        $error_msg[] = '파일의 업로드에 실패했습니다.';
                    }
                }
    
                if(count($error_msg) > 0) {
                    Util::error_back($error_msg[0]);
                } else {
                    $uploaded[$i] = array(true, $originalName, $saveFilename, $_FILES[$fields[$i]]['size'], $_FILES[$fields[$i]]['type']);
                }
            } else {
                $uploaded[$i] = array(false, '', '','' ,'' );
            }
        }
        return $uploaded;
    }
    
    /**
     * 다중 파일 업로드를 처리한다.
     *
     * @param unknown $field
     * @param unknown $up_folder
     */
    static function uploadFileMulti($field, $up_folder) {
        $uploaded = array();
        for($i = 0; $i < count($_FILES[$field]['name']); $i++) {
    
            if(is_uploaded_file($_FILES[$field]['tmp_name'][$i])) {
    
                list($result, $ext, $error_msg) = FileUtil::checkFileMulti($field, $i);
    
                if($result) {
    
                    $nameonly = FileUtil::filename($_FILES[$field]['name'][$i]);
    
                    $originalName = $nameonly . '.' . $ext;
    
                    $upFilename = md5(microtime(). $nameonly. $_SERVER['REMOTE_ADDR']) . '.' . $ext;
    
                    $tmp_name = $_FILES[$field]['tmp_name'][$i];
    
                    $saveFilename = "upfile_" . time() . $i . '_' . $upFilename;
    
                    $move_to = $up_folder . $saveFilename;
    
                    if(!move_uploaded_file($tmp_name, $move_to)) {
                        $error_msg[] = '이미지의 업로드에 실패했습니다.';
                    }
                }
    
                if(count($error_msg) > 0) {
                    Util::error_back($error_msg[0]);
                } else {
                    $uploaded[$i] = array(true, $originalName, $saveFilename, $_FILES[$field]['size'][$i], $_FILES[$field]['type'][$i]);
                }
            } else {
                $uploaded[$i] = array(false, '', '', '', '');
            }
        }
        return $uploaded;
    }
    
    /**
     * 멀티 업로드시 체크
     *
     * @param 업로드 폼 필드명 $fieldname
     * @param 인덱스 $idx
     */
    static function checkFileMulti($fieldname, $idx) {
    
        $size = $_FILES[$fieldname]['size'][$idx];
        $error = $_FILES[$fieldname]['error'][$idx];
        $name = $_FILES[$fieldname]['name'][$idx];
    
        return FileUtil::checkFile($size, $error, $name);
    }
    
    /**
     * 단일 파일 체크
     *
     * @param 업로드 폼 필드명 $fieldname
     */
    static function checkFileSingle($fieldname) {
    
        $size = $_FILES[$fieldname]['size'];
        $error = $_FILES[$fieldname]['error'];
        $name = $_FILES[$fieldname]['name'];
    
    
        return FileUtil::checkFile($size, $error, $name);
    }
    
    /**
     * 파일 체크
     * @param 업로드된 파일 크기 $size
     * @param 업로드 에러 코드 $error
     * @param 파일명 $name
     * @return boolean[]|unknown[]|string[][]|boolean[]|string[][]|mixed[]
     */
    static function checkFile($size, $error, $name) {
        global $settings;
    
        $error_msg = array();
    
        if($error != UPLOAD_ERR_OK) {
            if($error == UPLOAD_ERR_INI_SIZE || $error == UPLOAD_ERR_FORM_SIZE) {
                $error_msg[] = '파일 크기가 허용된 양보다 큽니다.';
            } else {
                $error_msg[] = '파일 업로드 오류 입니다.';
            }
            return array(false, $ext, $error_msg);
        }
    
        if($size == 0) {
            $error_msg[] = '파일이 존재하지 않거나 빈 파일 입니다.';
            return array(false, $ext, $error_msg);
        }
    
        $fileInfo = pathinfo($name);
    
        $ext = strtolower($fileInfo['extension']);
        $count = 0;
        for($i = 0; $i < count($settings['file_ext']); $i++) {
            if($ext == $settings['file_ext'][$i]) {
                $count++;
                break;
            }
        }
    
        if($count == 0) {
            $error_msg[] = $ext . " 는 업로드 가능한 확장자가 아닙니다.";
            return array(false, $ext, $error_msg);
        }
    
        return array(true, $ext, $error_msg);
    }
    
    /**
     * 파일 다운로드용 함수
     * @param 서버에 파일이 저장된 디렉토리 $serverDir ex) "/xx/saveFiles/", "D:/saveFiles/";
     * @param 다운로드창에 표시될 파일명 $orgFileName ex) "명단.xls"
     * @param 서버에 저장된 파일명 $realFileName    ex) "upfile_14537082110_e937f87359ad567be0657fbcdf22812a.pdf"
     */
    static function downloadFile($serverDir, $orgFileName, $realFileName){
        global $_SERVER;
        $realFilePath = addslashes($serverDir.$realFileName);// 화일이 실제로 있는 위치
    
        if (!is_file($realFilePath) || !file_exists($realFilePath)) {
            $realFilePath = iconv('utf-8', 'euc-kr', $realFilePath);
            if (!is_file($realFilePath) || !file_exists($realFilePath)) {
                Util::error_back_html('파일이 존재하지 않습니다.');
            }
        }
    
        $original = iconv('utf-8', 'euc-kr', $orgFileName);
        
        if(preg_match("/msie/i", $_SERVER['HTTP_USER_AGENT']) && preg_match("/5\.5/", $_SERVER['HTTP_USER_AGENT'])) {
            header("content-type: doesn/matter");
            header("content-length: ".filesize("$realFilePath"));
            header("content-disposition: attachment; filename=\"$original\"");
            header("content-transfer-encoding: binary");
        } else {
            header("content-type: application/octect-stream");
            header("content-length: ".filesize("$realFilePath"));
            header("content-disposition: attachment; filename=\"$original\"");
            header("content-transfer-encoding: binary");
        }
        header("pragma: no-cache");
        header("expires: 0");
        flush();
    
        $fp = fopen($realFilePath, 'rb');
    
        $download_rate = 10;
    
        while(!feof($fp)) {
    
            print fread($fp, round($download_rate * 1024));
            flush();
            usleep(1000);
        }
        fclose ($fp);
        flush();
    }
    
    /**
     * 파일 삭제용 함수
     * @param 서버에 파일이 저장된 디렉토리 $serverDir ex) "/xx/saveFiles/", "D:/saveFiles/";
     * @param 서버에 저장된 파일명 $realFileName    ex) "upfile_14537082110_e937f87359ad567be0657fbcdf22812a.pdf"
     * @return boolean 파일이 없거나 파일삭제가 실패하면 false, 파일이 있고 삭제작업이 성공한 경우에만 true
     */
    static function deleteFile($serverDir, $realFileName){
        $rtnValue = false;
        $realFilePath = addslashes($serverDir.$realFileName);// 화일이 실제로 있는 위치
    
        if (!is_file($realFilePath) || !file_exists($realFilePath)) {
            $realFilePath = iconv('utf-8', 'euc-kr', $realFilePath);
            if (is_file($realFilePath)  || file_exists($realFilePath)) {
                
                $rtnValue = unlink($realFilePath);
            }
        }else{
            $rtnValue = unlink($realFilePath);
        }
    
        return $rtnValue;
    }
}
?>