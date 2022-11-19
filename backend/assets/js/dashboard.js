
  let map;
  let lati;
  let langi;

  lati = parseFloat(23.614328);
  lngi = parseFloat(58.545284);
  const iconBase =baseurl+"backend/images/";
  console.log(iconBase);
  const icons = {
      active: {
        icon: iconBase + "active.png",
      },
      inactive: {
        icon: iconBase + "inactive.png",
      },
  };
  function initMap() {
    map = new google.maps.Map(document.getElementById("map_db"), {
      zoom: 16,
      center: new google.maps.LatLng(lati, lngi),
    });

  }

    $(document).ready(function() {


          $.ajax({
              url: baseurl + 'admin/dashboard/getstations',
              type: "get",
              dataType: "JSON",
              success: function(results) {
                  console.log(results); // server response
                  for (let i = 0; i < results.length; i++) {
                      //console.log(results[i]);
                      if(results[i].is_active=='yes')
                      {
                          const latLng = new google.maps.LatLng(results[i].lat, results[i].lng);
                          new google.maps.Marker({
                          position: latLng,
                          map: map,                
                          size: new google.maps.Size(20, 32),
                          icon: icons.active.icon,
                          title: results[i].outlet_name,
                          });
                      }
                      else
                      {
                          const latLng = new google.maps.LatLng(results[i].lat, results[i].lng);
                          new google.maps.Marker({
                          position: latLng,
                          map: map,                
                          size: new google.maps.Size(20, 32),
                          icon: icons.inactive.icon,
                          title: results[i].outlet_name,
                          }); 
                      }

                  }
              }
          });

            var url1='admin/dashboard/gettotalrevenue';
            $.ajax({
                url: baseurl + url1,
                type: "get",
                dataType: "JSON",
                success: function(result) {
                    Morris.Bar({
                        element: 'bar-charts',
                        data: result,
                        xkey: 'month',
                        ykeys: ['total'],
                        labels: ['Total Income'],
                        lineColors: ['#ff9b44'],
                        lineWidth: '2px',
                        barColors: ['#ff9b44'],
                        resize: true,
                        redraw: true
                    });
                }
            });

          var url2='admin/dashboard/getsalesoverview';
          $.ajax({
            url: baseurl + url2,
            type: "get",
            dataType: "JSON",
            success: function(result) {
              console.log(result);
              if(result.collections=='')
              {
                  result.collections=0;
              }
                Morris.Line({
                    element: 'line-charts',
                    data: result,
                    xkey: 'date',
                    ykeys: ['collections'],
                    labels: ['Total Income'],
                    lineColors: ['#ff9b44'],
                    lineWidth: '3px',
                    resize: true,
                    redraw: true
                });
            }
        });
      
          var url3='admin/dashboard/getissuedreturnedbatteries';
          $.ajax({
              url: baseurl + url3,
              type: "get",
              dataType: "JSON",
              success: function(result) {
                  console.log(result);
                  Morris.Bar({
                      element: 'bar-charts-battries',
                      data: result,
                      xkey: 'date',
                      ykeys: ['issued','returned'],
                      labels: ['Issued Batteries','Returned Batteries'],
                      lineColors: ['#ff9b44','#fc6075'],
                      lineWidth: '2px',
                      barColors: ['#ff9b44','#fc6075'],
                      resize: true,
                      redraw: true
                  });
              }
          });
      
      
          var url4 = 'admin/dashboard/getsubscribers';
          $.ajax({
              url: baseurl + url4,
              type: "get",
              dataType: "JSON",
              success: function(result) {
                  Morris.Line({
                      element: 'line-charts-usertrends',
                      data: result,
                      xkey: 'date',
                      ykeys: ['subscribers'],
                      labels: ['Subscribers'],
                      lineColors: ['#fc6075'],
                      lineWidth: '3px',
                      resize: true,
                      redraw: true
                  });
              }
          });
      
          var url5 = 'admin/dashboard/getosplatform';
          $.ajax({
              url: baseurl + url5,
              type: "get",
              dataType: "JSON",
              success: function(result) {
                  Morris.Donut({
                      element: 'bar-charts-osplatforms',
                      data: result,
                      colors: [
                      '#ff9b44',
                      '#fc6075'
                      ],
                  });
              }
          });    
      
          var url6 = 'admin/dashboard/getmobilemake';
          $.ajax({
              url: baseurl + url6,
              type: "get",
              dataType: "JSON",
              success: function(result) {
                  Morris.Donut({
                      element: 'line-charts-mobilemake',
                      data: result,
                      colors: [
                              '#ff9b44',
                              '#fc6075',
                              '#ff9b43',
                              '#fc6074',
                              '#ff9b42',
                              '#fc6073',
                              '#ff9b41',
                              '#fc6072',
                              '#ff9b40',
                              '#fc6071',
                              '#ff9b39',
                              '#fc6070'
                              ],
                  });
              }
          });    
  
  });
 



    


