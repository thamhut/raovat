//date picker v2

	Highcharts.theme = {
			   colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
			   chart: {
				  backgroundColor: {
					 linearGradient: [0, 0, 500, 500],
					 stops: [
						[0, 'rgb(239, 239, 239)']
					 ]
				  },
				  plotBackgroundColor: 'rgba(255, 255, 255, .9)',
				  plotBorderWidth: 1,
				  spacingRight: 30
			   },
			   title: {
				  style: { 
					 color: '#000',
					 font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
				  }
			   },
			   subtitle: {
				  style: { 
					 color: '#666666',
					 font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
				  }
			   },
			   xAxis: {
				  
				  labels: {					 
					 style: {
						color: '#000',
						font: '11px Trebuchet MS, Verdana, sans-serif'
					 }
				  },
				  tickColor: '#333',
				  title: {
					 style: {
						color: '#333',
						fontWeight: 'bold',
						fontSize: '12px',
						fontFamily: 'Trebuchet MS, Verdana, sans-serif'
			
					 }            
				  }
			   },
			   yAxis: {
			      allowDecimals: false,
				  //minorTickInterval: 'auto',
				  lineColor: '#aaa',
				  lineWidth: 1,
				  tickWidth: 1,
				  tickColor: '#999',
				  labels: {
					 style: {
						color: '#000',
						font: '11px Trebuchet MS, Verdana, sans-serif'
					 }
				  },
				  title: {
					 style: {
						color: '#333',
						fontWeight: 'bold',
						fontSize: '12px',
						fontFamily: 'Trebuchet MS, Verdana, sans-serif'
					 }            
				  }
				   
			   },
			   legend: {
				  itemStyle: {         
					 font: '9pt Trebuchet MS, Verdana, sans-serif',
					 color: 'black'
			
				  },
				  itemHoverStyle: {
					 color: '#039'
				  },
				  itemHiddenStyle: {
					 color: 'gray'
				  }
			   },
			   labels: {
				  style: {
					 color: '#99b'
				  }
			   }
			};
			