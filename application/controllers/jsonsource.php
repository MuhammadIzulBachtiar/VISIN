<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class jsonsource extends CI_Controller {

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
        $source=file_get_contents('assets/data.json');
        $source=json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $source), true);
        //data sales channel
        $result=array();
        $keysArray=array();
        foreach($source as $row)
        {
            if(!isset($result[$row['salesChannel']]))
            {
                $result[$row['salesChannel']]=array($row['custId']);
                array_push($keysArray,$row['salesChannel']);
            }else{
                array_push($result[$row['salesChannel']], $row['custId']);
            }
        }
        $keys=array_keys($result);
        $saleschannel=array();
        foreach($keys as $row)
        {
            $saleschannel[]=[$row,count($result[$row])];
        }
        $data['PieChartData']=json_encode($saleschannel);
        $data['PieChartTitle']='Data Sales Channel';
        $this->load->view('grafik',$data);

        //
        $result=array();
        $keysArray=array();
        foreach($source as $row)
        {
            if(!isset($result[$row['custCountry']]))
            {
                $result[$row['custCountry']]=array($row['custId']);
                array_push($keysArray,$row['custCountry']);
            }else{
                array_push($result[$row['custCountry']], $row['custId']);
            }
        }
        $keys=array_keys($result);
        $custcountry=array();
        foreach($keys as $row)
        {
            $custcountry[]=[$row,count($result[$row])];
        }
        $data['PieChartData2']=json_encode($custcountry);
        $data['PieChartTitle2']='Data Sales Channel';
        $this->load->view('grafik',$data);

        // data penjualan berdasarkan waktu
        $sales=[array('TANGGAL','UNIT SOLD 2012')];
        foreach($source as $row)
        {
            $year=date('Y',strtotime($row['dateSold']));
            $month=date('n',strtotime($row['dateSold']));
            if($year=='2012' && $month>5)
            {
                $dat=array($row['dateSold'],(double)$row['unitsSold']);
                array_push($sales, $dat);
            }
        }
        $data['LineChartData']=json_encode($sales);
        $data['LineChartTitle']='Data Penjualan';

        $this->load->view('grafik',$data);

         // sales total per bulan
         $salesTotal=[array('BULAN','TOTAL SOLD 2012', 'TOTAL SOLD 2011')];
         $totalData=array('2011'=>array(),'2012'=>array());
         foreach($source as $row)
         {
             $year=date('Y',strtotime($row['dateSold']));
             $month=date('n',strtotime($row['dateSold']));
             if($year=='2012')
             {
                if(!isset($totalData['2012'][$month]))
                {
                    $totalData['2012'][$month]=[(double)$row['unitsSold']];
                }else{
                    array_push($totalData['2012'][$month],(double)$row['unitsSold']);
                }
             }
             if($year=='2011')
             {
                if(!isset($totalData['2011'][$month]))
                {
                    $totalData['2011'][$month]=[(double)$row['unitsSold']];
                }else{
                    array_push($totalData['2011'][$month],(double)$row['unitsSold']);
                }
             }
         }
         $months=array_keys($totalData['2012']);
         for($i=1; $i<=12; $i++)
         {
            $dat12=0;
            $dat11=0;
            if(isset($totalData['2012'][$i])) $dat12=array_sum($totalData['2012'][$i]);
            if(isset($totalData['2011'][$i])) $dat11=array_sum($totalData['2011'][$i]);
            $dt=[$i,$dat12,$dat11];
            array_push($salesTotal,$dt);
         }
         $data['BarChartData']=json_encode($salesTotal);
         $data['BarChartTitle']='Akumulasi Data Penjualan Tahun 2011 & 2012';
 
         $this->load->view('grafik',$data);
//         foreach(array_keys($totalData['2012']) as $row)
//         {
//            $dat=[$row,array_sum($totalData['2012'][$row]),array_sum($totalData['2011'][$row])];
//            array_push($salesTotal,$dat);
//         }
//         //echo json_encode($salesTotal);
 //        $data['BarChartData']=json_encode($salesTotal);
//        $data['BarChartTitle']='Akumulasi Data Penjualan Tahun 2011 & 2012';
 
//         $this->load->view('grafik',$data);
        }
}