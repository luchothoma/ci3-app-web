$(document).ready(function(){
    var table = $('#tableUsers').DataTable( {
	    'language': {
	        'url': base_url+'./assets/jquery.dataTables/datatables.Spanish.json'
	    },
        responsive: true,
    });
});