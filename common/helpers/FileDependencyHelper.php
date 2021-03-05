<?php
/**
 * FileDependencyHelper.php
 * @author: allen
 * @date  2020年6月16日下午5:07:20
 * @copyright  Copyright igkcms
 */
namespace common\helpers;

use Yii;
use yii\helpers\FileHelper;

class FileDependencyHelper extends \yii\base\BaseObject
{
    /**
     * @var string 文件依赖缓存根目录
     */
    public $rootDir = '@runtime/cache/file_dependency/';
    
    /**
     * @var string 文件名
     */
    public $fileName;
    
    
    /**
     * 创建缓存依赖文件
     *
     * @return bool|string
     */
    public function createFile()
    {
        $cacheDependencyFileName = $this->getDependencyFileName();
        if ( ! file_exists(dirname($cacheDependencyFileName)) ) {
            FileHelper::createDirectory(dirname($cacheDependencyFileName));
        }
        file_put_contents($cacheDependencyFileName, uniqid());
        return $cacheDependencyFileName;
    }
    
    /**
     * 更新缓存依赖文件
     */
    public function updateFile()
    {
        $cacheDependencyFileName = $this->getDependencyFileName();
        if (file_exists($cacheDependencyFileName)) {
            file_put_contents($cacheDependencyFileName, uniqid());
        }
    }
    
    /**
     * 获取包含路径的文件名
     *
     * @return bool|string
     */
    protected function getDependencyFileName()
    {
        return Yii::getAlias($this->rootDir . $this->fileName);
    }
}