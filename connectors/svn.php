<?php 
header('Content-Type: application/json');

#Need to install pecl svn
#sudo apt-get install libsvn-dev
#sudo pecl install svn
#echo "extension=svn.so" >  /etc/php5/apache2/conf.d/svn.ini

$root = 'http://svn.apache.org/repos/asf/subversion/';

//svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_USERNAME, 'username');
//svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_PASSWORD, 'name');


$dir='/';
if(!empty($_GET['dir'])){
	$dir = $_GET['dir'];
	if($dir[0]=='/'){
	    $dir = '.'.$dir.'/';
	}

}

$return = $dirs = $fi = array();

$files = svn_ls($root.$dir);
// All dirs
foreach( $files as $key => $file ) {
    if($file['type']=='dir'){
        $dirs[] = array('type'=>$file['type'],'dir'=>'','file'=>$key);
    }else{
        $fi[] = array('type'=>$file['type'],'dir'=>'','file'=>$key,'ext'=>getExt($key));
    }
    $return = array_merge($dirs,$fi);
}

echo json_encode( $return );


function getExt($file){
	$dot = strrpos($file, '.') + 1;
        return substr($file, $dot);
}
?>
