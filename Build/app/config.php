<?php
  $config = array(
    'company_name'=>  'Company Name',
    'local_ip'=>      getHostByName(getHostName()),
    'server_path'=>   $_SERVER['SERVER_NAME']
  );
  $projects = array();
  $folders = array_filter(glob('/www/sites/*'), 'is_dir');


  function project_properties($file){
    $properties = array();
    $doc = new DOMDocument();
    $doc->loadHTML(file_get_contents($file));

    $list = $doc->getElementsByTagName("title");
    if ($list->length > 0) {
        $properties['title'] = $list->item(0)->textContent;
    }

    $list = $doc->getElementsByTagName("link");
    $href = "";
    foreach ($list as $item) {
      $rel = $item->getAttribute('rel');
      if ($rel == 'apple-touch-icon') {
        $href = $item->getAttribute('href');
        break;
      }
    }
    if($href!==''){
      $properties['icon'] = $href;
    }
    return $properties;
  }

  foreach($folders as $folder){

    $project = new stdClass;

    $project->path = $folder;
    $dirsplit = explode('/', $folder);
    $dirname = $dirsplit[count($dirsplit)-1];
    $project->folder = $dirname;

    if (file_exists($folder.'/build/index.html')) {
      $properties = project_properties($folder.'/build/index.html');
      if(isSet($properties['title'])){
        $project->name = $properties['title'];
      }else{
        $project->hidden = true;
      }
      if(isSet($properties['icon'])){
        $project->icon = $properties['icon'];
      }
    }else if (file_exists($folder.'/build/index.php')) {
        $project->name = page_title($folder.'/build/index.php');
    }else{
      $project->hidden = true;
    }

    $projects[] = $project;
  }
  $config['projects'] = $projects;

  die(json_encode($config));
 ?>