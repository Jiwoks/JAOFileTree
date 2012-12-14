<?php 
//header('Content-Type: application/json');
$dir='/';
if(!empty($_GET['dir'])){
	$dir = $_GET['dir'];
	if($dir[0]=='/'){
	    $dir = '.'.$dir.'/';
	}

}
$dir = str_replace('..', '', $dir);
$root = dirname(__FILE__).'/../';

$return = $dirs = $fi = array();

if( file_exists($root . $dir) ) {            
        $files = scandir($root . $dir);

        natcasesort($files);
        if( count($files) > 2 ) { /* The 2 accounts for . and .. */
                // All dirs
                foreach( $files as $file ) {			
                        if( file_exists($root . $dir . $file) && $file != '.' && $file != '..' && is_dir($root . $dir . $file) ) {
                                $dirs[] = array('type'=>'dir','dir'=>$dir,'file'=>$file);
                        }elseif( file_exists($root . $dir . $file) && $file != '.' && $file != '..' && !is_dir($root . $dir . $file) ) {
                                $fi[] = array('type'=>'file','dir'=>$dir,'file'=>$file,'ext'=>strtolower(getExt($file)));
                        }
                }
		$return = array_merge($dirs,$fi);
        }
}
echo json_encode( $return );


function getExt($file){
	$dot = strrpos($file, '.') + 1;
        return substr($file, $dot);
}
?>
