<?php
namespace Libraries;

class Email {
    
    public function __construct(){
        
    }
	public function email($penerima='',$pengirim='',$nama='',$subjek='',$pesan='',$files='')
	{
		$file='upload/voucher/'.$files;
		$penerima=$penerima;
		$pengirim=$pengirim;
		$nama=$nama;
		$subjek=$subjek;
		$pesan=$pesan;
		$ukuran=filesize($file);
		$buka=fopen($file,"r");
		$baca=fread($buka,$ukuran);
		
		fclose($buka);
		$konten=base64_encode($baca);
		$konten=chunk_split($konten);
		$uid=md5(uniqid(time()));
		$nama_file=basename($file);
		$header="From:".$nama."<".$pengirim.">\r\n";
		$header.="Reply-To:".$pengirim."\r\n";
		$header.="MIME-Version: 1.0\r\n";
		$header.="Content-Type:multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
		$header.="--".$uid."\r\n";
		$header.="Content-type:text/plain; charset=iso-8859-1\r\n";
		$header.="Content-Transfer-Encoding: 7bit\r\n \r\n";
		$header.=$pesan."\r\n\r\n";
		$header.="--".$uid."\r\n";
		$header.="Content-Type:image/jpeg; name=\"".$nama_file."\"\r\n";
		$header.="Content-Transfer-Encoding: base64\r\n";
		$header.="Content-Disposition: attachment; filename=\"".$nama_file."\"\r\n\r\n";
		$header.=$konten."\r\n\r\n";
		$header.="--".$uid."--";
		
		return mail($penerima,$subjek,$pesan,$header);
		
	}
	
}