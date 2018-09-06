<?php

class File_Manager
{
    private $attachmentDir = "attachment";

    private $mimeConfig = array(
        "image/png" => "png",
        "image/jpeg" => "jpeg",
        "image/jpg" => "jpg",
        "image/gif" => "gif",
//        "image/bmp" => "bmp",
//        "audio/mp4" => "mp4",
//        "video/mp4" => "mp4",
    );

    private $defaultImgType = [
        "image/jpeg",
        "image/jpg",
        "image/png",
    ];

    public function __construct()
    {
        $this->wpf_Logger = new Wpf_Logger();
    }

    public function getPath($dateDir, $fileId)
    {
        $dirName = WPF_LIB_DIR . "/../{$this->attachmentDir}/$dateDir";
        if (!is_dir($dirName)) {
            mkdir($dirName, 0755, true);
        }
        return $dirName . "/" . $fileId;
    }

    public function readFile($fileId)
    {
        if (strlen($fileId) < 1) {
            return "";
        }
        // 需要hash目录，防止单目录文件过多
        $fileName = explode("-", $fileId);
        $dirName = $fileName[0];
        $fileId = $fileName[1];
        $path = $this->getPath($dirName, $fileId);
        return file_get_contents($path);
    }

    public function contentType($fileId) {
        if (strlen($fileId) < 1) {
            return "";
        }
        // 需要hash目录，防止单目录文件过多
        $fileName = explode("-", $fileId);
        $dirName = $fileName[0];
        $fileId = $fileName[1];
        $path = $this->getPath($dirName, $fileId);
        return mime_content_type($path);
    }

    public function saveFile($content)
    {
        $dateDir = date("Ymd");

        $fileName = sha1(uniqid());

        $path = $this->getPath($dateDir, $fileName);
        file_put_contents($path, $content);

        $mime = mime_content_type($path);

        if (!in_array($mime, $this->defaultImgType)) {
            throw new Exception("file type error");
        }

        $ext = isset($this->mimeConfig[$mime]) ? $this->mimeConfig[$mime] : "";
        if (false == empty($ext)) {
            $fileName = $fileName . "." . $ext;
            rename($path, $this->getPath($dateDir, $fileName));
        }

        return $dateDir . "-" . $fileName;
    }

    public function buildGroupAvatar($fileIdList = array())
    {
        if (empty($fileIdList)) {
            return "";
        }

        $picList = [];
        foreach ($fileIdList as $fileId) {
            $userAvatarPath = $this->turnFileId2FilePath($fileId);
            if (isset($userAvatarPath)) {
                $picList[] = $userAvatarPath;
            }
        }

        $dateDir = date("Ymd");
        $fileName = sha1(uniqid()) . "." . "jpeg";
        $groupImagePath = $this->getPath($dateDir, $fileName);

        $gorupAvatarPath = $this->splicingGroupAvatar($picList, $groupImagePath);

        if (empty($gorupAvatarPath)) {
            return null;
        }
        return $dateDir . "-" . $fileName;
    }

    /**
     * avatar from fileId to path
     * @param $fileId
     * @return string
     */
    private function turnFileId2FilePath($fileId)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        if (empty($fileId)) {
            return null;
        }
        try {
            $fileNameArray = explode("-", $fileId);
            $dirName = $fileNameArray[0];
            $fileName = $fileNameArray[1];
            return $this->getPath($dirName, $fileName);
        } catch (Exception $e) {
            $this->wpf_Logger->error($tag, $e->getMessage());
        }
        return null;
    }

    /**
     * php gd
     * https://blog.csdn.net/dongqinliuzi/article/details/48273185
     *
     * @param array $picList
     * @param $outImagePath
     * @return bool|string
     */
    private function splicingGroupAvatar($picList = array(), $outImagePath)
    {
        $tag = __CLASS__.'-'.__FUNCTION__;
        if (!function_exists("imagecreatetruecolor")) {
            $this->wpf_Logger->error($tag, "php need support gd library, please check local php environment");
            return null;
        }

        if (empty($picList)) {
            return "";
        }

        $default_width = 500;
        $default_height = 500;

        $picList = array_slice($picList, 0, 9); // 只操作前9个图片

        $background = imagecreatetruecolor($default_width, $default_height); // 背景图片

        //int imagecolorallocate ( resource $image , int $red , int $green , int $blue ) 为一幅图像分配颜色
        $color = imagecolorallocate($background, 202, 201, 201); // 为真彩色画布创建白色背景，再设置为透明
        imagefill($background, 0, 0, $color);           //区域填充
        imageColorTransparent($background, $color);     // 将某个颜色定义为透明色

        $pic_count = count($picList);
        $lineArr = array();  // 需要换行的位置
        $space_x = 3;
        $space_y = 3;
        $line_x = 0;

        switch ($pic_count) {
            case 1: // 正中间
                $start_x = intval($default_width / 4);  // 开始位置X
                $start_y = intval($default_height / 4);  // 开始位置Y
                $pic_w = intval($default_width / 2); // 宽度
                $pic_h = intval($default_height / 2); // 高度
                break;
            case 2: // 中间位置并排
                $start_x = 2;
                $start_y = intval($default_height / 4) + 3;
                $pic_w = intval($default_width / 2) - 5;
                $pic_h = intval($default_height / 2) - 5;
                $space_x = 5;
                break;
            case 3:
                $start_x = 124;   // 开始位置X
                $start_y = 5;    // 开始位置Y
                $pic_w = intval($default_width / 2) - 5; // 宽度
                $pic_h = intval($default_height / 2) - 5; // 高度
                $lineArr = array(2);
                $line_x = 4;
                break;
            case 4:
                $start_x = 4;    // 开始位置X
                $start_y = 5;    // 开始位置Y
                $pic_w = intval($default_width / 2) - 5; // 宽度
                $pic_h = intval($default_height / 2) - 5; // 高度
                $lineArr = array(3);
                $line_x = 4;
                break;
            case 5:
                $start_x = 85.5;   // 开始位置X
                $start_y = 85.5;   // 开始位置Y
                $pic_w = intval($default_width / 3) - 5; // 宽度
                $pic_h = intval($default_height / 3) - 5; // 高度
                $lineArr = array(3);
                $line_x = 5;
                break;
            case 6:
                $start_x = 5;    // 开始位置X
                $start_y = 85.5;   // 开始位置Y
                $pic_w = intval($default_width / 3) - 5; // 宽度
                $pic_h = intval($default_height / 3) - 5; // 高度
                $lineArr = array(4);
                $line_x = 5;
                break;
            case 7:
                $start_x = 166.5;   // 开始位置X
                $start_y = 5;    // 开始位置Y
                $pic_w = intval($default_width / 3) - 5; // 宽度
                $pic_h = intval($default_height / 3) - 5; // 高度
                $lineArr = array(2, 5);
                $line_x = 5;
                break;
            case 8:
                $start_x = 80.5;   // 开始位置X
                $start_y = 5;    // 开始位置Y
                $pic_w = intval($default_width / 3) - 5; // 宽度
                $pic_h = intval($default_height / 3) - 5; // 高度
                $lineArr = array(3, 6);
                $line_x = 5;
                break;
            case 9:
                $start_x = 5;    // 开始位置X
                $start_y = 5;    // 开始位置Y
                $pic_w = intval($default_width / 3) - 5; // 宽度
                $pic_h = intval($default_height / 3) - 5; // 高度
                $lineArr = array(4, 7);
                $line_x = 5;
                break;
        }


        foreach ($picList as $k => $pic_path) {
            $kk = $k + 1;
            if (in_array($kk, $lineArr)) {
                $start_x = $line_x;
                $start_y = $start_y + $pic_h + $space_y;
            }
            $resource = false;
            $mime = mime_content_type($pic_path);

            if ($mime == "image/jpg" | $mime == "image/jpeg") {
                $resource = imagecreatefromjpeg($pic_path);
            } else if ($mime == "image/png") {
                $resource = imagecreatefrompng($pic_path);
            } else {
                $this->wpf_Logger->error($tag, "unsupport image type [" . $mime . "]");
            }
            if ($resource == false) {
                continue;
            }
            // $start_x,$start_y copy图片在背景中的位置
            // 0,0 被copy图片的位置   $pic_w,$pic_h copy后的高度和宽度
            imagecopyresized($background, $resource, $start_x, $start_y, 0, 0, $pic_w, $pic_h, imagesx($resource), imagesy($resource)); // 最后两个参数为原始图片宽度和高度，倒数两个参数为copy时的图片宽度和高度
            $start_x = $start_x + $pic_w + $space_x;
        }

        // header("Content-type: image/jpg");
        // imagejpeg($background);die;

        // 保存图像为 $imagePath.'$fname'.'.jpg'
        $res = imagejpeg($background, $outImagePath);
        if (false === $res) {
            return false;
        }

        // 释放内存
        imagedestroy($background);

        return $outImagePath;
    }
}