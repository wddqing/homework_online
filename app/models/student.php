<?php

	class student{
		
		/**
		 * @var 教师编号
		 */
		protected $teacherId;
		/**
		 * @var 教师名字
		 */
		protected $teacherName;
		/**
		 * @var 班级编号
		 */
		protected $classId;
		/**
		 * @var 课程编号
		 */
		protected $lessonId;
		/**
		 * @var 课程名称
		 */
		protected $lessonName;
		/**
		 * @var 专业
		 */
		protected $major;
		/**
		 * @var 上课地址
		 */
		protected $address;
		/**
		 * @var 学号
		 */
		protected $studentId;
		/**
		 * @var 学生名字
		 */
		protected $studentName;
		
		//将学生与班级关系保存进数据库
		public function save(){
			
		}
		//判断该学生是否存在
		public function exist($id){
			
		} 
		
	}
?>