<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class student extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
    {
		//data gender siswa
        $source=file_get_contents('assets/StudentJson.json');
        $source=json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $source), true);
        $result=array();
        $keysArray=array();
        foreach($source as $row)
        {
            if(!isset($result[$row['Gender']]))
            {
                $result[$row['Gender']]=array($row['ID']);
                array_push($keysArray,$row['Gender']);
            }else{
                array_push($result[$row['Gender']], $row['ID']);
            }
        }
        $keys=array_keys($result);
        $gender=array();
        foreach($keys as $row)
        {
            $gender[]=[$row,count($result[$row])];
        }
        $data['PieChartData']=json_encode($gender);
        $data['PieChartTitle']='Data Gender Siswa';
        $this->load->view('student',$data);

		// data major
		$source=file_get_contents('assets/StudentJson.json');
        $source=json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $source), true);
        $result=array();
		$keysArray=array();
        foreach($source as $row)
        {
            if(!isset($result[$row['Major']]))
            {
                $result[$row['Major']]=array($row['ID']);
                array_push($keysArray,$row['Major']);
            }else{
                array_push($result[$row['Major']], $row['ID']);
            }
        }
        $keys=array_keys($result);
        $major=array();
        foreach($keys as $row)
        {
            $major[]=[$row,count($result[$row])];
        }
        $data['BarChartData']=json_encode($major);
        $data['BarChartTitle']='Data Major';
        $this->load->view('student',$data);

		 //grade data 
		 $grade=[array('TANGGAL','Grade')];
		 foreach($source as $row)
		 {
			 $year=date('Y',strtotime($row['TestDate']));
			 if($year=='2022')
			 {
				 $dat=array($row['TestDate'],(double)$row['Grade ']);
				 array_push($grade, $dat);
			 }
		 }
		 $data['LineChartData']=json_encode($grade);
		 $data['LineChartTitle']='Data Nilai Berdasarkan Tanggal Test';
 
		 $this->load->view('student',$data);


    }
}