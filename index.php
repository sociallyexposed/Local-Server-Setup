<!DOCTYPE html>
<html ng-app="LocalServer">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link href="assets/img/icon.png" rel="apple-touch-icon" />

    <title>Local Server</title>
    <!-- @stylesheet app/assets/css/semantic-ui-2.2.12-min.css -->
    <!-- @reload -->
  </head>
  <body ng-controller="localserver">
    <div class="container" style="margin:20px;">
      <div class="ui secondary stackable menu" style="border-bottom:1px solid #ccc;">
        <div class="header item">
            {{config.company_name}}
        </div>
        <a class="active item">
          Open
        </a>
        <a class="item">
          Closed
        </a>
        <div class="right menu">
          <a class="item">
            <i class="icon add" style="margin:0px;padding:0px;"></i>
          </a>
          <div class="item">
            <div class="ui basic mini buttons">
              <button class="ui button" ng-click="set_layout('grid');" ng-class="{'active':layout=='grid'}">
                <i class="icon grid layout" style="margin:0px;padding:0px;"></i>
              </button>
              <button class="ui button" ng-click="set_layout('list');" ng-class="{'active':layout=='list'}">
                <i class="icon list layout" style="margin:0px;padding:0px;"></i>
              </button>
            </div>
          </div>
          <div class="item">
            <form class="ui icon input">
              <input type="text" placeholder="Search..." ng-model="q">
              <i class="search link icon"></i>
            </form>
          </div>
          <a class="ui item" href="http://home.{{config.local_ip}}.xip.io" ng-hide="config.xip">
            <i class="icon safari" style="margin:0px;padding:0px;"></i>
          </a>
          <a class="ui item active" href="http://home.dev" ng-show="config.xip">
            <i class="icon safari blue" style="margin:0px;padding:0px;"></i>
          </a>
        </div>
      </div>
      <div class="ui cards" style="position:relative;" ng-show="layout=='grid'">
        <a class="card" ng-click="launch(project.folder);" ng-repeat="project in projects = (config.projects | filter: q)" ng-hide="project.hidden">
          <div class="content">
            <img class="right floated mini ui image rounded" ng-src="{{resourse(project.folder,project.icon)}}"/>
            <div class="header">
              {{project.name}}
            </div>
            <div class="meta">
              {{project.path}}
            </div>
          </div>
          <div class="content">
            <div class="description">
              <p>{{project.folder}}.dev/{{project.icon}}</p>
            </div>
          </div>
          <div class="content extra">
            <i class="folder outline icon"></i>
            {{project.folder}}/
          </div>
        </a>
      </div>
      <table class="ui very basic celled table" ng-show="layout=='list'">
        <thead>
          <tr>
            <th>Project</th>
            <th>Location</th>
            <th>options</th>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="project in projects = (config.projects | filter: q)" ng-hide="project.hidden">
            <td>
              <h4 class="ui image header">
                <img class="mini ui image rounded" ng-src="{{resourse(project.folder,project.icon)}}"/>
                <div class="content">
                  {{project.name}}
                  <div class="sub header">
                    {{project.path}}
                  </div>
                </div>
              </h4>
            </td>
            <td>
              <i class="folder outline icon"></i>
              {{project.folder}}/
            </td>
            <td></td>
          </tr>
        </tbody>
      </table>

        d



      <div ng-show="projects.length==0" style="position:relative; margin-top:80px; text-align:center;">
        <h2 class="ui icon header" style="color:#eee;">
          <i class="search icon" style="font-size:22px;"></i> No results found.
        </h2>
      </div>
    </div><!-- /.container -->
    <!-- @javascript app/assets/js/jQuery-3.2.1-min.js -->
    <!-- @javascript app/assets/js/angular-1.6.5-min.js -->
    <!-- @javascript app/assets/js/semantic-ui-2.2.12-min.js -->
    <!-- @javascript app/app.js -->
  </body>
</html>
