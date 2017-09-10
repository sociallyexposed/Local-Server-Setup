<?php
  $config = array(
    'company_name'=>  'Company Name',
    'domain'=>        'local-serve.dev',
    'local_ip'=>      getHostByName(getHostName()),
    'server_path'=>   $_SERVER['SERVER_NAME'],
    'atom'=>          true

  );
  $projects = array();
  $folders = array_filter(glob('/www/sites/*'), 'is_dir');


  class localServer{

    public function gitBranch(){
      if($this->isGitAvailable()){
        $gitHead = file('.git/HEAD', FILE_USE_INCLUDE_PATH);
        $line1 = $gitHead[0]; //get the string from the array
        $branch = explode("/", $line1, 3); //seperate out by the "/" in the string
        $branchName = $branch[2]; //get the one that is always the branch name
        return $branchName;
      }else{
        return FALSE;
      }
    }
    public function isGitAvailable(){
      /* Checks to see if the local project has a valid .git path */
      if (!file_exists('../.git/HEAD')) {
        return TRUE;
      }else{
        return FALSE;
      }
    }

  }

  $server = new localServer();

  


  function project_properties($file){
    $properties = array();
    $doc = new DOMDocument();
    $doc->loadHTML(file_get_contents($file));

    $list = $doc->getElementsByTagName("title");
    if ($list->length > 0) {
        $properties['title'] = $list->item(0)->textContent;
    }

    $list = $doc->getElementsByTagName("meta");
    $description = "";
    foreach ($list as $item) {
      $rel = $item->getAttribute('name');
      if ($rel == 'description') {
        $description = $item->getAttribute('content');
        break;
      }
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
    if($description!==''){
      $properties['description'] = $description;
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

      $properties = project_properties($folder.'/build/index.php');
      if(isSet($properties['title'])){
        $project->name = $properties['title'];
      }else{
        $project->hidden = true;
      }
      if(isSet($properties['icon'])){
        $project->icon = $properties['icon'];
      }
    }else{

      $project->hidden = true;
    }

    $projects[] = $project;
  }
  $config['projects'] = $projects;

  die(json_encode($config));
 ?>