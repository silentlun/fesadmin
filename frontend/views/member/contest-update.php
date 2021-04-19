<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Json;
use common\widgets\JsBlock;
use common\models\ContestType;

$this->title = '修改参赛信息';
?>
<div class="container my-5">
	<div class="row">
		<div class="col-md-3">
		<?= $this->render('_left') ?>
		</div>
		<div class="col-md-9">
			<div class="card" id="app">
				<div class="card-body">
					<div class="headline d-flex justify-content-between">
						<h4 class="head-title">修改参赛信息</h4>
					</div>
					<div class="mt-4">
					<?php $form = ActiveForm::begin(['id' => 'form-contest', 'enableClientScript' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>

                    <?= $form->field($model, 'type_id')->dropdownList(ContestType::getTypes(), ['prompt'=>'选择参赛组别']);?>
                    
                    <?= $form->field($model, 'title') ?>
                    
                    <div class="form-group pb-3 border-bottom">
							<h6>添加团队成员</h6>
							<small class="form-text text-muted">
								(最多可以添加3个成员，个人组请不要添加，添加无效)
							</small>
						</div>
						<div class="form-inline">
							<input type="text" class="form-control mb-2 mr-sm-2" name="q" v-model="studentKeyword" placeholder="输入队友姓名">

							<button type="button" class="btn btn-primary mb-2" @click="searchStudent">查找</button>
						</div>
						<small class="form-text text-muted mb-3">
							输入队友姓名，点击“查找”按钮，等待查询结果，进行添加
						</small>
						<div class="py-2 px-3 mb-3 bg-light text-dark">待选队员</div>
						<div class="row cansai-userlist">
							<div class="col-6" v-for="(item,index) in studentData" :key="index">
								<div class="media">
									<img class="align-self-start mr-3" src="/statics/images/default_head.png">
									<div class="media-body">
										<h5>{{item.name}}</h5>
										<p>{{item.school}} {{item.college}}</p>
									</div>
									<div class="align-self-center ml-auto">
										<button type="button" class="btn btn-sm" :class="[item.selected == 1 ? 'btn-secondary' : 'btn-success']" :disabled="item.selected == 1" @click="selectUser(item)">+ 添加</button>
									</div>
								</div>
							</div>
						</div>
						<div class="py-2 px-3 mb-3 bg-light text-dark">已选队员</div>
						<div class="d-flex userselect">
							<div class="col-4" v-for="(item,index) in selectedStudent">
							<div class="alert alert-success">
								<button type="button" class="close" @click="cancelUser(item)">
									<span aria-hidden="true">&times;</span>
								</button>
								<div class="media">
									<img class="align-self-start mr-3" src="/statics/images/default_head.png">
									<div class="media-body">
										<h5>{{item.name}}</h5>
										<p>已添加</p>
									</div>

								</div>
							</div>
							</div>
							
						</div>
                    
                    <div class="form-group pb-3 border-bottom">
							<h6><strong>添加指导老师</strong></h6>
							<small class="form-text text-muted">
								(每组可填加 0-2名指导老师)
							</small>
						</div>
						<div class="form-inline">
							<input type="text" class="form-control mb-2 mr-sm-2" name="q" v-model="teacherKeyword" placeholder="输入老师姓名">
						
							<button type="button" class="btn btn-primary mb-2" @click="searchTeacher">查找</button>
						</div>
						<small class="form-text text-muted mb-3">
							输入老师姓名，点击“查找”按钮，等待查询结果，进行添加
						</small>
						<div class="py-2 px-3 mb-3 bg-light text-dark">待选老师</div>
						<div class="row cansai-userlist">
							<div class="col-6" v-for="(item,index) in teacherData">
								<div class="media">
									<img class="align-self-start mr-3" src="/statics/images/default_head.png">
									<div class="media-body">
										<h5>{{item.name}}</h5>
										<p>{{item.company}} {{item.teaching}}</p>
									</div>
									<div class="align-self-center ml-auto">
										<button type="button" class="btn btn-sm" :class="[item.selected == 1 ? 'btn-secondary' : 'btn-success']" :disabled="item.selected == 1" @click="selectUser(item,1)">+ 添加</button>
									</div>
								</div>
							</div>
						</div>
						<div class="py-2 px-3 mb-3 bg-light text-dark">已选老师</div>
						<div class="d-flex userselect">
							<div class="col-4" v-for="(item,index) in selectedTeacher">
							<div class="alert alert-success">
								<button type="button" class="close" @click="cancelUser(item,1)">
									<span aria-hidden="true">&times;</span>
								</button>
								<div class="media">
									<img class="align-self-start mr-3" src="/statics/images/default_head.png">
									<div class="media-body">
										<h5>{{item.name}}</h5>
										<p>已添加</p>
									</div>

								</div>
							</div>
							</div>
							
						</div>
					
					<div class="form-group pb-3 border-bottom">
							<h6><strong>上传报名计划书</strong></h6>
							<small class="form-text text-muted">
								(注：不修改计划书该项请留空)
							</small>
						</div>
						<div class="form-group">
							<label>上传文件</label>
							<div class="custom-file">
								<?= Html::activeInput('file', $model, 'upfile', ['class' => 'custom-file-input']) ?>
								<label class="custom-file-label" for="customFile" data-browse="浏览">选择文件</label>
							</div>
							<small id="passwordHelpBlock" class="form-text text-muted">
                            </small>
						</div>
                
                    <div class="form-group d-flex justify-content-center">
                        <div class="col-md-3"><?= Html::submitButton('确认修改', ['class' => 'btn btn-primary btn-block']) ?></div>
                    </div>
                    <!-- <input type="hidden" id="contest-student" name="Contest[student]" v-model="students">
                    <input type="hidden" id="contest-student" name="Contest[student]" v-model="teachers"> -->
                    <?= Html::activeInput('hidden', $model, 'student', ['v-model' => 'students']) ?>
				<?= Html::activeInput('hidden', $model, 'teacher', ['v-model' => 'teachers']) ?>
                <?php ActiveForm::end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php JsBlock::begin()?>
<script>
	var vm = new Vue({
		el: '#app',
		data: {
			studentData: [],
			selectedStudent: <?=Json::encode($students)?>,
			studentKeyword:'',
			students:<?=$model->student ? Json::encode(explode(',', $model->student)) : '[]';?>,
			teacherData: [],
			selectedTeacher: <?=Json::encode($teachers)?>,
			teacherKeyword:'',
			teachers:<?=$model->teacher ? Json::encode(explode(',', $model->teacher)) : '[]';?>,
			step:1,
			prevStatus:false,
			nextStatus:true,
			type:'',
			title:'',
			upFile:'',
		},
		methods: {
			searchStudent() {
				if(!this.studentKeyword){
					swal({text:'请输入队员姓名查询',icon:'error',buttons: false,timer: 2000,});
					return false;
				}
				var that = this;
				layer.load(2);
				$.getJSON("<?=Url::toRoute(['contest/search'])?>",{role:1,q:this.studentKeyword},function(res){
					const datas = res.data.map((item) => {
						return {
							id: item.id,
							name: item.username,
							school: item.profile != null ? item.profile.school : '',
							college: item.profile != null ? item.profile.college : '',
							selected: that.filterStudent(item.id),
						};
					});
					that.studentData = datas;
					layer.closeAll('loading');
					//console.log(JSON.stringify(that.studentData))
		        });
				/* let result = [
					{id:1,fullname:'所得税',school:'北京大学',college:'计算机工程学院'},
					{id:2,fullname:'的奋斗',school:'清华大学',college:'地理测绘工程学院'}
				];
				const data = result.map((item) => {
					return {
						id: item.id,
						name: item.fullname,
						school: item.school,
						college: item.college,
						selected: 0
					};
				});
				this.studentData = data;
				console.log(JSON.stringify(this.studentData)) */
				
			},
			searchTeacher() {
				if(!this.teacherKeyword){
					swal({text:'请输入导师姓名查询',icon:'error',buttons: false,timer: 2000,});
					return false;
				}
				var that = this;
				layer.load(2);
				$.getJSON("<?=Url::toRoute(['contest/search'])?>",{role:2,q:this.teacherKeyword},function(res){
					const datas = res.data.map((item) => {
						return {
							id: item.id,
							name: item.username,
							company: item.profile != null ? item.profile.company : '',
							teaching: item.profile != null ? item.profile.teaching : '',
							selected: that.filterStudent(item.id),
						};
					});
					that.teacherData = datas;
					layer.closeAll('loading');
					//console.log(JSON.stringify(that.teacherData))
		        });
				
			},
			selectUser(item, type = 0) {
				if(type == 0){
					if(this.students.length >= 3){
						swal({text:'队员最多选择3人！',icon:'error',buttons: false,timer: 2000,});
						return false;
					}
					this.students.push(item.id);
					this.selectedStudent.push(item);
				}else{
					if(this.teachers.length >= 2){
						swal({text:'指导老师最多选择2人！',icon:'error',buttons: false,timer: 2000,});
						return false;
					}
					this.teachers.push(item.id);
					this.selectedTeacher.push(item);
				}
				this.initData(item.id, 0, type);
				console.log(JSON.stringify(this.students))
				
			},
			cancelUser(item, type = 0){
				if(type == 0){
					for(let i = 0; i < this.selectedStudent.length; i++){
						if(this.selectedStudent[i].id == item.id){
							this.selectedStudent.splice(i,1);
							this.students.splice(this.students.indexOf(i),1);
						}
					}
				}else{
					for(let i = 0; i < this.selectedTeacher.length; i++){
						if(this.selectedTeacher[i].id == item.id){
							this.selectedTeacher.splice(i,1);
							this.teachers.splice(this.teachers.indexOf(i),1);
						}
					}
				}
				this.initData(item.id, 1, type);
			},
			initData(id, s = 0, type = 0){
				if(type == 0){
					for(let i = 0; i < this.studentData.length; i++){
						if(this.studentData[i].id == id){
							if(s == 0){
								this.studentData[i].selected = 1;
							}else{
								this.studentData[i].selected = 0;
							}
						}
					}
				}else{
					for(let i = 0; i < this.teacherData.length; i++){
						if(this.teacherData[i].id == id){
							if(s == 0){
								this.teacherData[i].selected = 1;
							}else{
								this.teacherData[i].selected = 0;
							}
						}
					}
				}
				//console.log(JSON.stringify(this.studentData))
			},
			filterStudent(e){
				let selected = 0;
				for(let i = 0; i < this.selectedStudent.length; i++){
					if(this.selectedStudent[i].id == e){
						selected = 1;
					}
				}
				return selected;
			},
			filterTeacher(e){
				let selected = 0;
				for(let i = 0; i < this.selectedTeacher.length; i++){
					if(this.selectedTeacher[i].id == e){
						selected = 1;
					}
				}
				return selected;
			},
			submitBuyForm(){
				$('#form-contest').submit();
			}
		},
	});
</script>
<?php JsBlock::end()?>