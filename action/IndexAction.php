<?php
header("Content-type: text/html; charset=utf-8");
include './model/IMAPModel.class.php';
include './model/DBModel.class.php';

error_reporting(E_ALL);

class IndexAciton{
    public $username = 's125hckj@ooopic.com';
    public $password = 'Hdy123456';
    public $email_address = 's125hckj@ooopic.com';
    public $resmail_server = '{pop.exmail.qq.com:143/imap}INBOX';
    public $mail_server = 'pop.exmail.qq.com';
    public $server_type = 'imap';
    public $port = 143;
    public $db;

    public function __construct()
    {
        $this->db=new DBModel();
    }

    public function run()
    {
        $mail=$this->getMailCont(1280);
        echo $mail['mailcont'];
        $this->saveMail($mail['mailid'],$mail['mailcont']);
        if(true || stripos($mail['mailcont'],'开通权限')!==false){
            $mail_str=str_ireplace('/<br>/','\n',$mail['mailcont']);
            $mail_str=preg_replace('/<style.*?>.*?<\/style>|<script.*?>.*?<\/script>|<[a-z]{1,}.*?>|<\/[a-z]{1,}>/','',$mail_str);
            $mail_str=str_ireplace('/\\n/','<br>',$mail_str);
            if($mail_str){
                $sql="UPDATE dydb_mail SET mail_content_text='$mail_str' WHERE mail_id={$mail['mailid']}";
                $this->db->execute($sql);
            }

            if(preg_match('/开通用户(.*?)<br>/',$mail_str,$result)){
                var_dump($result);
            }else{
                return '开通用户格式错误';
            }
        }else{
            return '非开通权限邮件';
        }

    }

    /**
     * 为空则获取获取最近一封邮件
     * */
    public function getMailCont($mailid=null){
        echo $sql="SELECT id,mail_content_text FROM dydb_mail WHERE mail_id=$mailid";
        $res=$this->db->query($sql);
        $data=$res->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data[0]['id'])){
            $mailcont=$data[0]['mail_content_text'];
        }else{
            $mail = new IMAPModel($this->username,$this->password,$this->email_address,$this->mail_server,$this->server_type,$this->port);
            $mail->connect();
            $mailid=empty($mailid)?$mail->get_mail_total():$mailid;
            $mailcont=iconv('gbk','utf-8',$mail->get_body($mailid));
        }
        return array('mailid'=>$mailid,'mailcont'=>$mailcont);
    }



    public function saveMail($mailid,$mailcont){
        $updatetime=date('Y-m-d H:i:s');
        $sql="INSERT INTO `dydb_mail` (`mail_id`, `username`, `updatetime`, `mail_content_source`, `mail_content_text`) VALUES ( {$mailid}, '黄德银', '{$updatetime}', '{$mailcont}', '')";
        $this->db->execute($sql);
    }

}
$pm=new IndexAciton();
$pm->run();
echo 'ok';