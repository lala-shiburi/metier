<template>
  <div>
    <card :title="$t('home')">
      <div class="card-header">
        Your Jobseed dashboard
      </div>
      <div class="row">
        <div class="col-sm-6 col-lg-3">
          <div class="card text-white bg-primary">
            <div class="card-body pb-0">
              <div class="btn-group float-right">
                <button type="button" class="btn btn-transparent dropdown-toggle p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="icon-settings"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </div>
              <div class="text-value">823</div>
              <div>Members online</div>
            </div>
            <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
              <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                  <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                </div>
                <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                  <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                </div>
              </div>
              <canvas id="card-chart1" class="chart chartjs-render-monitor" height="70" width="156" style="display: block; width: 156px; height: 70px;"></canvas>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="card text-white bg-info">
            <div class="card-body pb-0">
              <button type="button" class="btn btn-transparent p-0 float-right">
                <i class="icon-location-pin"></i>
              </button>
              <div class="text-value">901</div>
              <div>Available Jobs</div>
            </div>
            <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
              <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                  <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                </div>
                <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                  <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                </div>
              </div>
              <canvas id="card-chart2" class="chart chartjs-render-monitor" height="70" width="156" style="display: block; width: 156px; height: 70px;"></canvas>
              <div id="card-chart2-tooltip" class="chartjs-tooltip top" style="opacity: 0; left: 90.5576px; top: 127.767px;">
                <div class="tooltip-header">
                  <div class="tooltip-header-item">March</div>
                </div>
                <div class="tooltip-body">
                  <div class="tooltip-body-item">
                    <span class="tooltip-body-item-color" style="background-color: rgb(38, 203, 253);"></span>
                    <span class="tooltip-body-item-label">My First dataset</span>
                    <span class="tooltip-body-item-value">9</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="card text-white bg-warning">
            <div class="card-body pb-0">
              <div class="btn-group float-right">
                <button type="button" class="btn btn-transparent dropdown-toggle p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="icon-settings"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </div>
              <div class="text-value">581</div>
              <div>Companies</div>
            </div>
            <div class="chart-wrapper mt-3" style="height:70px;">
              <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                  <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                </div>
                <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                  <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                </div>
              </div>
              <canvas id="card-chart3" class="chart chartjs-render-monitor" height="70" width="188" style="display: block; width: 188px; height: 70px;"></canvas>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="card text-white bg-danger">
            <div class="card-body pb-0">
              <div class="btn-group float-right">
                <button type="button" class="btn btn-transparent dropdown-toggle p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="icon-settings"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </div>
              <div class="text-value">9.823</div>
              <div>Openings</div>
            </div>
            <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
              <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                  <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                </div>
                <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                  <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                </div>
              </div>
              <canvas id="card-chart4" class="chart chartjs-render-monitor" height="70" width="156" style="display: block; width: 156px; height: 70px;"></canvas>
              <div id="card-chart4-tooltip" class="chartjs-tooltip top" style="opacity: 0; left: 167px; top: 100.6px;">
                <div class="tooltip-header">
                  <div class="tooltip-header-item">April</div>
                </div>
                <div class="tooltip-body">
                  <div class="tooltip-body-item">
                    <span class="tooltip-body-item-color" style="background-color: rgba(230, 230, 230, 0.2);"></span>
                    <span class="tooltip-body-item-label">My First dataset</span>
                    <span class="tooltip-body-item-value">82</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <table class="table table-responsive-sm table-hover table-outline mb-0">
        <thead class="thead-light">
          <tr>
            <th class="text-center">
              <i class="icon-people"></i>
            </th>
            <th>User</th>
            <th class="text-center">Country</th>
            <th>Usage</th>
            <th class="text-center">Payment Method</th>
            <th>Activity</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center">
              <div class="avatar">
                <img :src="public_path + '/images/avatars/1.jpg'" class="img-avatar" alt="admin@bootstrapmaster.com">
                <span class="avatar-status badge-success"></span>
              </div>
            </td>
            <td>
              <div>Yiorgos Avraamu</div>
              <div class="small text-muted">
                <span>New</span> | Registered: Jan 1, 2015
              </div>
            </td>
            <td class="text-center">
              <i class="flag-icon flag-icon-us h4 mb-0" title="us" id="us"></i>
            </td>
            <td>
              <div class="clearfix">
                <div class="float-left">
                  <strong>50%</strong>
                </div>
                <div class="float-right">
                  <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                </div>
              </div>
              <div class="progress progress-xs">
                <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </td>
            <td class="text-center">
              <i class="fa fa-cc-mastercard" style="font-size:24px"></i>
            </td>
            <td>
              <div class="small text-muted">Last login</div>
              <strong>10 sec ago</strong>
            </td>
          </tr>
          <tr>
            <td class="text-center">
              <div class="avatar">
                <img :src="public_path + '/images/avatars/2.jpg'" class="img-avatar" alt="admin@bootstrapmaster.com">
                <span class="avatar-status badge-danger"></span>
              </div>
            </td>
            <td>
              <div>Avram Tarasios</div>
              <div class="small text-muted">
                <span>Recurring</span> | Registered: Jan 1, 2015
              </div>
            </td>
            <td class="text-center">
              <i class="flag-icon flag-icon-br h4 mb-0" title="br" id="br"></i>
            </td>
            <td>
              <div class="clearfix">
                <div class="float-left">
                  <strong>10%</strong>
                </div>
                <div class="float-right">
                  <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                </div>
              </div>
              <div class="progress progress-xs">
                <div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </td>
            <td class="text-center">
              <i class="fa fa-cc-visa" style="font-size:24px"></i>
            </td>
            <td>
              <div class="small text-muted">Last login</div>
              <strong>5 minutes ago</strong>
            </td>
          </tr>
          <tr>
            <td class="text-center">
              <div class="avatar">
                <img :src="public_path + '/images/avatars/3.jpg'" class="img-avatar" alt="admin@bootstrapmaster.com">
                <span class="avatar-status badge-warning"></span>
              </div>
            </td>
            <td>
              <div>Quintin Ed</div>
              <div class="small text-muted">
                <span>New</span> | Registered: Jan 1, 2015
              </div>
            </td>
            <td class="text-center">
              <i class="flag-icon flag-icon-in h4 mb-0" title="in" id="in"></i>
            </td>
            <td>
              <div class="clearfix">
                <div class="float-left">
                  <strong>74%</strong>
                </div>
                <div class="float-right">
                  <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                </div>
              </div>
              <div class="progress progress-xs">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 74%" aria-valuenow="74" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </td>
            <td class="text-center">
              <i class="fa fa-cc-stripe" style="font-size:24px"></i>
            </td>
            <td>
              <div class="small text-muted">Last login</div>
              <strong>1 hour ago</strong>
            </td>
          </tr>
          <tr>
            <td class="text-center">
              <div class="avatar">
                <img :src="public_path + '/images/avatars/4.jpg'" class="img-avatar" alt="admin@bootstrapmaster.com">
                <span class="avatar-status badge-secondary"></span>
              </div>
            </td>
            <td>
              <div>Enéas Kwadwo</div>
              <div class="small text-muted">
                <span>New</span> | Registered: Jan 1, 2015
              </div>
            </td>
            <td class="text-center">
              <i class="flag-icon flag-icon-fr h4 mb-0" title="fr" id="fr"></i>
            </td>
            <td>
              <div class="clearfix">
                <div class="float-left">
                  <strong>98%</strong>
                </div>
                <div class="float-right">
                  <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                </div>
              </div>
              <div class="progress progress-xs">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 98%" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </td>
            <td class="text-center">
              <i class="fa fa-paypal" style="font-size:24px"></i>
            </td>
            <td>
              <div class="small text-muted">Last login</div>
              <strong>Last month</strong>
            </td>
          </tr>
          <tr>
            <td class="text-center">
              <div class="avatar">
                <img :src="public_path + '/images/avatars/5.jpg'" class="img-avatar" alt="admin@bootstrapmaster.com">
                <span class="avatar-status badge-success"></span>
              </div>
            </td>
            <td>
              <div>Agapetus Tadeáš</div>
              <div class="small text-muted">
                <span>New</span> | Registered: Jan 1, 2015
              </div>
            </td>
            <td class="text-center">
              <i class="flag-icon flag-icon-es h4 mb-0" title="es" id="es"></i>
            </td>
            <td>
              <div class="clearfix">
                <div class="float-left">
                  <strong>22%</strong>
                </div>
                <div class="float-right">
                  <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                </div>
              </div>
              <div class="progress progress-xs">
                <div class="progress-bar bg-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </td>
            <td class="text-center">
              <i class="fa fa-google-wallet" style="font-size:24px"></i>
            </td>
            <td>
              <div class="small text-muted">Last login</div>
              <strong>Last week</strong>
            </td>
          </tr>
          <tr>
            <td class="text-center">
              <div class="avatar">
                <img :src="public_path + '/images/avatars/6.jpg'" class="img-avatar" alt="admin@bootstrapmaster.com">
                <span class="avatar-status badge-danger"></span>
              </div>
            </td>
            <td>
              <div>Friderik Dávid</div>
              <div class="small text-muted">
                <span>New</span> | Registered: Jan 1, 2015
              </div>
            </td>
            <td class="text-center">
              <i class="flag-icon flag-icon-pl h4 mb-0" title="pl" id="pl"></i>
            </td>
            <td>
              <div class="clearfix">
                <div class="float-left">
                  <strong>43%</strong>
                </div>
                <div class="float-right">
                  <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                </div>
              </div>
              <div class="progress progress-xs">
                <div class="progress-bar bg-success" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </td>
            <td class="text-center">
              <i class="fa fa-cc-amex" style="font-size:24px"></i>
            </td>
            <td>
              <div class="small text-muted">Last login</div>
              <strong>Yesterday</strong>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-6">
                <div class="callout callout-info">
                  <small class="text-muted">New Clients</small>
                  <br>
                  <strong class="h4">9,123</strong>
                  <div class="chart-wrapper">
                    <canvas id="sparkline-chart-1" width="100" height="30"></canvas>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="callout callout-danger">
                  <small class="text-muted">Recuring Clients</small>
                  <br>
                  <strong class="h4">22,643</strong>
                  <div class="chart-wrapper">
                    <canvas id="sparkline-chart-2" width="100" height="30"></canvas>
                  </div>
                </div>
              </div>

            </div>

            <hr class="mt-0">
            <div class="progress-group mb-4">
              <div class="progress-group-prepend">
                <span class="progress-group-text">
                  Monday
                </span>
              </div>
              <div class="progress-group-bars">
                <div class="progress progress-xs">
                  <div class="progress-bar bg-info" role="progressbar" style="width: 34%" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress progress-xs">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
            <div class="progress-group mb-4">
              <div class="progress-group-prepend">
                <span class="progress-group-text">
                  Tuesday
                </span>
              </div>
              <div class="progress-group-bars">
                <div class="progress progress-xs">
                  <div class="progress-bar bg-info" role="progressbar" style="width: 56%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress progress-xs">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 94%" aria-valuenow="94" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
            <div class="progress-group mb-4">
              <div class="progress-group-prepend">
                <span class="progress-group-text">
                  Wednesday
                </span>
              </div>
              <div class="progress-group-bars">
                <div class="progress progress-xs">
                  <div class="progress-bar bg-info" role="progressbar" style="width: 12%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress progress-xs">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 67%" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
            <div class="progress-group mb-4">
              <div class="progress-group-prepend">
                <span class="progress-group-text">
                  Thursday
                </span>
              </div>
              <div class="progress-group-bars">
                <div class="progress progress-xs">
                  <div class="progress-bar bg-info" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress progress-xs">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 91%" aria-valuenow="91" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
            <div class="progress-group mb-4">
              <div class="progress-group-prepend">
                <span class="progress-group-text">
                  Friday
                </span>
              </div>
              <div class="progress-group-bars">
                <div class="progress progress-xs">
                  <div class="progress-bar bg-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress progress-xs">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 73%" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
            <div class="progress-group mb-4">
              <div class="progress-group-prepend">
                <span class="progress-group-text">
                  Saturday
                </span>
              </div>
              <div class="progress-group-bars">
                <div class="progress progress-xs">
                  <div class="progress-bar bg-info" role="progressbar" style="width: 53%" aria-valuenow="53" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress progress-xs">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 82%" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
            <div class="progress-group mb-4">
              <div class="progress-group-prepend">
                <span class="progress-group-text">
                  Sunday
                </span>
              </div>
              <div class="progress-group-bars">
                <div class="progress progress-xs">
                  <div class="progress-bar bg-info" role="progressbar" style="width: 9%" aria-valuenow="9" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress progress-xs">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 69%" aria-valuenow="69" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-6">
                <div class="callout callout-warning">
                  <small class="text-muted">Pageviews</small>
                  <br>
                  <strong class="h4">78,623</strong>
                  <div class="chart-wrapper">
                    <canvas id="sparkline-chart-3" width="100" height="30"></canvas>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="callout callout-success">
                  <small class="text-muted">Organic</small>
                  <br>
                  <strong class="h4">49,123</strong>
                  <div class="chart-wrapper">
                    <canvas id="sparkline-chart-4" width="100" height="30"></canvas>
                  </div>
                </div>
              </div>

            </div>

            <hr class="mt-0">
            <div class="progress-group">
              <div class="progress-group-header">
                <i class="icon-user progress-group-icon"></i>
                <div>Male</div>
                <div class="ml-auto font-weight-bold">43%</div>
              </div>
              <div class="progress-group-bars">
                <div class="progress progress-xs">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
            <div class="progress-group mb-5">
              <div class="progress-group-header">
                <i class="icon-user-female progress-group-icon"></i>
                <div>Female</div>
                <div class="ml-auto font-weight-bold">37%</div>
              </div>
              <div class="progress-group-bars">
                <div class="progress progress-xs">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
            <div class="progress-group">
              <div class="progress-group-header align-items-end">
                <i class="icon-globe progress-group-icon"></i>
                <div>Organic Search</div>
                <div class="ml-auto font-weight-bold mr-2">191.235</div>
                <div class="text-muted small">(56%)</div>
              </div>
              <div class="progress-group-bars">
                <div class="progress progress-xs">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 56%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
            <div class="progress-group">
              <div class="progress-group-header align-items-end">
                <i class="icon-social-facebook progress-group-icon"></i>
                <div>Facebook</div>
                <div class="ml-auto font-weight-bold mr-2">51.223</div>
                <div class="text-muted small">(15%)</div>
              </div>
              <div class="progress-group-bars">
                <div class="progress progress-xs">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
            <div class="progress-group">
              <div class="progress-group-header align-items-end">
                <i class="icon-social-twitter progress-group-icon"></i>
                <div>Twitter</div>
                <div class="ml-auto font-weight-bold mr-2">37.564</div>
                <div class="text-muted small">(11%)</div>
              </div>
              <div class="progress-group-bars">
                <div class="progress progress-xs">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 11%" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
            <div class="progress-group">
              <div class="progress-group-header align-items-end">
                <i class="icon-social-linkedin progress-group-icon"></i>
                <div>LinkedIn</div>
                <div class="ml-auto font-weight-bold mr-2">27.319</div>
                <div class="text-muted small">(8%)</div>
              </div>
              <div class="progress-group-bars">
                <div class="progress progress-xs">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 8%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <br>
      </div>

    </card>

    <!-- Footer -->
    <footer class="page-footer font-small mdb-color lighten-3 pt-4">

      <!-- Footer Links -->
      <div class="container text-center text-md-left">

        <!-- Grid row -->
        <div class="row">

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 mr-auto my-md-4 my-0 mt-4 mb-1">

            <!-- Content -->
            <h5 class="font-weight-bold text-uppercase mb-4">Footer Content</h5>
            <p>Here you can use rows and columns here to organize your footer content.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit amet numquam iure provident voluptate esse quasi,
              veritatis totam voluptas nostrum.</p>

          </div>
          <!-- Grid column -->

          <hr class="clearfix w-100 d-md-none">

          <!-- Grid column -->
          <div class="col-md-2 col-lg-2 mx-auto my-md-4 my-0 mt-4 mb-1">

            <!-- Links -->
            <h5 class="font-weight-bold text-uppercase mb-4">About</h5>

            <ul class="list-unstyled">
              <li>
                <p>
                  <a href="#!">PROJECTS</a>
                </p>
              </li>
              <li>
                <p>
                  <a href="#!">ABOUT US</a>
                </p>
              </li>
              <li>
                <p>
                  <a href="#!">BLOG</a>
                </p>
              </li>
              <li>
                <p>
                  <a href="#!">AWARDS</a>
                </p>
              </li>
            </ul>

          </div>
          <!-- Grid column -->

          <hr class="clearfix w-100 d-md-none">

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 mx-auto my-md-4 my-0 mt-4 mb-1">

            <!-- Contact details -->
            <h5 class="font-weight-bold text-uppercase mb-4">Address</h5>

            <ul class="list-unstyled">
              <li>
                <p>
                  <i class="fa fa-home mr-3"></i> New York, NY 10012, US</p>
              </li>
              <li>
                <p>
                  <i class="fa fa-envelope mr-3"></i> info@example.com</p>
              </li>
              <li>
                <p>
                  <i class="fa fa-phone mr-3"></i> + 01 234 567 88</p>
              </li>
              <li>
                <p>
                  <i class="fa fa-print mr-3"></i> + 01 234 567 89</p>
              </li>
            </ul>

          </div>
          <!-- Grid column -->

          <hr class="clearfix w-100 d-md-none">

          <!-- Grid column -->
          <div class="col-md-2 col-lg-2 text-center mx-auto my-4">

            <!-- Social buttons -->
            <h5 class="font-weight-bold text-uppercase mb-4">Follow Us</h5>

            <!-- Facebook -->
            <a type="button" class="btn-floating btn-fb">
              <i class="fa fa-facebook"></i>
            </a>
            <!-- Twitter -->
            <a type="button" class="btn-floating btn-tw">
              <i class="fa fa-twitter"></i>
            </a>
            <!-- Google +-->
            <a type="button" class="btn-floating btn-gplus">
              <i class="fa fa-google-plus"></i>
            </a>
            <!-- Dribbble -->
            <a type="button" class="btn-floating btn-dribbble">
              <i class="fa fa-dribbble"></i>
            </a>

          </div>
          <!-- Grid column -->

        </div>
        <!-- Grid row -->

      </div>
      <!-- Footer Links -->

      <!-- Copyright -->
      <div class="footer-copyright text-center py-3">© 2018 Copyright:
        <a href="https://nexseed.net"> Nexseed Inc.</a>
      </div>
      <!-- Copyright -->

    </footer>
    <!-- Footer -->
  </div>
</template>

<script>
  export default {
    middleware: 'auth',

    data: () => ({
      public_path: location.origin
    }),

    metaInfo() {
      return {
        title: this.$t('home')
      }
    }
  }

</script>
