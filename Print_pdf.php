<?php
namespace Libraries;
use Resources, Models, Libraries;

class Print_pdf {
    
    public function __construct(){	
		$this->pdf = Resources\Import::vendor('mpdf60/mpdf');
		$this->hotel = new Models\Hotel;
		$this->pengaturan = new Models\Pengaturan;
		$this->booking = new Models\Booking;
    }
	public function cetak_voucher($id_pemesanan='')
	{
		
		//Data_print_pdf
			$data_print=$this->booking->viewall_by_ID($id_pemesanan);
			
			$tgl_checkin=$data_print->checkin;
			$tgl_checkout=$data_print->checkout;			
			$selisih_hari=(strtotime ($tgl_checkout) - strtotime ($tgl_checkin)) / (60*60*24);
			
			
			//data_hotel
			$data_hotel=$this->hotel->view_nama_alamat_kec_byId($data_print->id_hotel);
			$nama_hotel=$data_hotel->nama_hotel;
			$alamat=$data_hotel->alamat;
			$kecamatan=$data_hotel->kecamatan;			
			$nama_kecamatan=$this->pengaturan->get_nama_kec_karawang_byId($kecamatan)->nama_kec;
			
			//data_kamar
			$data_kamar=$this->hotel->view_kamar_byId($data_print->id_kamar);
			$nama_kamar=$data_kamar->nama_kamar;
			$harga='Rp. '.number_format($data_kamar->harga,0,'','.');
			
				$filename='voucher-'.$data_print->no_pesanan;
				$nama_guest = $data_print->nama_guest;
				$tlp = $data_print->tlp;
				$email = $data_print->email;
				$no_pesanan = $data_print->no_pesanan;
				$checkin = date("d-M, Y",strtotime($data_print->checkin));
				$checkout = date("d-M, Y",strtotime($data_print->checkout));
				$selisih_hari = $selisih_hari;
				$nama_hotel = $nama_hotel;
				$alamat_hotel = $alamat.', '.$nama_kecamatan;
				$nama_kamar =$nama_kamar;
				$jml_kamar = $data_print->jml_kamar;
				$selisih_hari = $selisih_hari;
				$harga =$harga;
				$total_bayar = 'Rp. '.number_format($data_print->total_bayar,0,'','.');			
				$permintaan = $data_print->permintaan;
		
		
		
		$this->pdf->mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0); 
 
		$this->pdf->SetDisplayMode('fullpage');
		 
		$this->pdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
		//$file=$this->uri->baseUri.'tmp_voucher/voucher_email.php';
		//$this->pdf->WriteHTML(file_get_contents($file));
		$html='
			<!DOCTYPE html>
			<html>
			<head>
				<title>Print Invoice</title>
			   <style>
			   *
			{
				margin:0;
				padding:0;
				font-family:Arial;
				font-size:10pt;
				color:#000;
			}
			body
			{
				width:100%;
				font-family:Arial;
				font-size:10pt;
				margin:0;
				padding:0;
			}
			 
			p
			{
				margin:0;
				padding:0;
			}
			 
			#wrapper
			{
				width:180mm;
				margin:0 15mm;
				border:0.1mm dashed #220044; 
				border-radius: 2mm;
				background-clip: border-box;
				padding:1mm;
			}

			 
			.page
			{
				height:297mm;
				width:210mm;
				page-break-after:always;
			}

			#table_border
			{
				border-left: 1px solid #ccc;
				border-top: 1px solid #ccc;
				 
				border-spacing:0;
				border-collapse: collapse; 
				 
			}
			 
			#table_border td 
			{
				border-right: 1px solid #ccc;
				border-bottom: 1px solid #ccc;
				padding: 2mm;
			}
			 
			#table_border.heading
			{
				height:50mm;
			}
			 
			h1.heading
			{
				font-size:14pt;
				color:#000;
				font-weight:normal;
			}
			 
			h2.heading
			{
				font-size:9pt;
				color:#000;
				font-weight:normal;
			}
			 
			hr
			{
				color:#ccc;
				background:#ccc;
			}
			 
			#invoice_body
			{
				height: auto;
				/* height: 149mm; */
			}
			 
			#invoice_body , #invoice_total
			{   
				width:100%;
			}
			#invoice_body table , #invoice_total table
			{
				width:100%;
				border-left: 1px solid #ccc;
				border-top: 1px solid #ccc;

				border-spacing:0;
				border-collapse: collapse; 
				 
				margin-top:5mm;
				margin-bottom:2mm;
			}
			 
			#invoice_body table td , #invoice_total table td
			{
				text-align:center;
				font-size:9pt;
				border-right: 1px solid #ccc;
				border-bottom: 1px solid #ccc;
				padding:2mm 0;
			}
			 
			#invoice_body table td.mono  , #invoice_total table td.mono
			{
				font-family:monospace;
				text-align:right;
				padding-right:3mm;
				font-size:10pt;
			}
			 
			#footer
			{   
				width:180mm;
				margin:0 15mm;
				padding-bottom:3mm;
			}
			#footer table
			{
				width:100%;
					 
				border-spacing:0;
				border-collapse: collapse; 
			}
			#footer table td
			{
				width:25%;
				text-align:center;
				font-size:9pt;
			}
			   
			   </style>
			</head>
			<body>
			<div id="wrapper" >
				<p style="text-align:left; font-weight:bold; padding-top:5mm;">
				<img src="logo2.png" style="width:50%">
				</p>
				<br />
				<table class="heading" style="width:100%;">
					<tr>
						<td >
							<table >
								<tr>
									<td style="width:80mm;" colspan="3">
									<h1 class="heading"><b><u>Customer Detail</u></b></h1></td>
								</tr>
								<tr>
								<td style="width:12mm;"><b>Nama</b></td>
								<td style="width:1mm;">:</td>
								<td style="width:67mm;">'.$nama_guest.'</td>			
								</tr>
								<tr>
								<td><strong>Phone</strong></td>
								<td >:</td>
								<td>'.$tlp.'</td>			
								</tr>
								<tr>
								<td><strong>Email</strong></td>
								<td >:</td>
								<td>'.$email.'</td>			
								</tr>
							</table>
							
						</td>
						<td rowspan="2" valign="top" align="right" style="padding:3mm;">
							<table id="table_border">
								<tr><td>No. Pesanan : </td><td>'.$no_pesanan.'</td></tr>
								<tr><td>Checkin : </td><td>'.$checkin.'</td></tr>
								<tr><td>Checkout : </td><td>'.$checkout.'</td></tr>
								<tr><td></td><td>'.$selisih_hari.' Hari</td></tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
						<table >
								<tr>
									<td style="width:80mm;" colspan="3">
									<h1 class="heading"><b><u>Hotel</u></b></h1></td>
								</tr>
								<tr>
								<td style="width:22mm;"><strong>Nama Hotel<strong></td>
								<td style="width:1mm;">:</td>
								<td style="width:57mm;">'.$nama_hotel.'</td>			
								</tr>
								<tr>
								<td ><strong>Alamat</strong></td>
								<td >:</td>
								<td >'.$alamat.','.$nama_kecamatan.'</td>			
								</tr>
						</table>
						</td>
					</tr>
				</table>
					 
					 
				<div id="content">
					 
					<div id="invoice_body">
						<table>
						<tr style="background:#eee;">
							<td rowspan="2" style="width:5%;"><b>No</b></td>
							<td rowspan="2"><b>Rooms</b></td>
							<td colspan="2"><b>Quantity</b></td>
							<td rowspan="2" style="width:20%;"><b>Rate</b></td>
							<td rowspan="2" style="width:25%;"><b>Total</b></td>
						</tr>
						<tr style="background:#eee;">
							<td style="width:10%;"><b>Rooms</b></td>
							<td style="width:10%;"><b>Days</b></td>
						</tr>
						</table>
						 
						<table>
						<tr>
							<td style="width:5%;">1</td>
							<td style="text-align:left; padding-left:10px;">'.$nama_kamar.'</td>
							<td class="mono" style="width:10%;">'.$jml_kamar.'</td>
							<td class="mono" style="width:10%;">'.$selisih_hari.'</td>
							<td style="width:20%;" class="mono">'.$harga.'</td>
							<td style="width:25%;" class="mono">'.$total_bayar.'</td>
						</tr>      
						 
					</table>
					</div>
					<br/>	
					<div id="invoice_total">
					   Permintaan Khusus :
						<table>
							<tr>
								<td class="mono" style="text-align:center; ">'.$permintaan.'</td>
								
							</tr>
						</table>
					</div>
					<br />
					<hr />
					<br />
					 
					<table style="width:100%; height:35mm;">
						<tr>
							<td style="width:65%; text-align:left;" valign="top" class="mono">
								Informasi :<br />
								<ol>
									<li>Kunjungi alamat <a href="http://hotelkarawang.com/index.php/cek">http://hotelkarawang.com/index.php/cek</a>, untuk pengecekan Voucher.</li>
									<li>Hubungi kami untuk penjelasan lebih lanjut.</li>
								</ol>
								
							</td>
						</tr>
					</table>
				</div>
				 
				<br />
				</div>
				 
				<htmlpagefooter name="footer">
					<hr />
					<div id="footer"> 
						<table>
							<tr >
							<td><img src="phone.png" > &nbsp;<strong>Customer Service</strong></td>
							<td><strong>Customer Service Email</strong></td>
							<td rowspan="2"><img src="logo2.png" style="width:25%;"></td>
							</tr>
							<tr>
							<td>085699999</td>
							<td>cs@hotelkarawang.com</td>
							
							</tr>
						</table>
					</div>
				</htmlpagefooter>
				<sethtmlpagefooter name="footer" value="on" />
				 
			</body>
			</html>
		';
		$this->pdf->WriteHTML($html);
				 
		$this->pdf->Output('upload/voucher/'.$filename.'.pdf','F');
		//$this->pdf->Output();
		
	}
	
}