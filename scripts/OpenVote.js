		function f(id){
			document.getElementById(id).value = "";
		}
		function redirect(loc){
			window.location = loc;
		}
		function invertColors(id){
			$(id).style = 'background-image: -ms-linear-gradient(top, #00A0EB 0%, #00A0EB 50%, #2DBCFF 51%, #2DBCFF 100%);background-image:-moz-linear-gradient(top, #00A0EB 0%, #00A0EB 50%, #2DBCFF 51%, #2DBCFF 100%);\background-image: -o-linear-gradient(top, #00A0EB 0%, #00A0EB 50%, #2DBCFF 51%, #2DBCFF 100%);background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #00A0EB), color-stop(0.5, #00A0EB),color-stop(0.51, #2DBCFF), color-stop(1, #2DBCFF));background-image: -webkit-linear-gradient(top, #00A0EB 0%, #00A0EB 50%, #2DBCFF 51%, #2DBCFF 100%);background-image: linear-gradient(to bottom, #00A0EB 0%, #00A0EB 50%, #2DBCFF 51%, #2DBCFF 100%);';	
		}
    