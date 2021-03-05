Yii2 插件整合-图片上传（file-upload）

实例教程：http://www.yii-china.com/post/detail/15.html

安装扩展：

1.点击上面扩展下载下载扩展

然后重命名为file_upload放在/common/widgets文件夹中

2.在使用图片上传控件的控制器（controller）中，加入以下代码

    public function actions()
    {
        return [
            'upload'=>[
                'class' => 'common\widgets\file_upload\UploadAction',     //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ]
        ];
    }
    
3.views渲染图片上传界面有两种方式：

第一种：不带model

<pre>
use common\widgets\webuploader\Webuploader;   //引入扩展
echo Webuploader::widget();
echo Webuploader::widget(['value'=>$url]);    //如果编辑时要带默认图，$url为图片路径
</pre>

第二种：带model

<pre>
$form = ActiveForm::begin(); 
    echo $form->field($model, 'thumb')->widget('common\widgets\webuploader\Webuploader',[
        'config'=>[
            'server'=>'', 上传地址
			'formData'=>'',
			'multiple'=>'', 多图上传
			'fileNumLimit'=>'',多图上传最大数量
			'fileSizeLimit'=>'',验证文件总大小是否超出限制,
			'fileSingleSizeLimit'=>'',上传图片大小限制500k
			'acceptExtensions'=>'gif,jpg,jpeg,png', 允许的文件后缀，不带点，多个用逗号分割,默认为gif,jpg,jpeg,png
			'showType'=>'',上传文件样式，thumb：图片模式，input：文本框模式，为空模式为thumb
        ]
    ]);
ActiveForm::end();
</pre>

