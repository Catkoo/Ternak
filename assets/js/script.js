// TOGGLE SIDEBAR
function toggle() {
    var side = document.getElementById("sidebar");
    side.classList.toggle("active");
    var page = document.getElementById("page");
    page.classList.toggle("active");
    
    console.log(side);
    console.log(page);
}

// data table
$('#data-table').DataTable();
// SELECT 2
$(document).ready(function() {
    $('.select2').select2();
});

// MENAMPILKAN LIST HISTORY
$(document).ready(function() {
    setInterval(function () {
        getHistory()
    }, 100);
});
function getHistory() {
	$.getJSON("Components/pages/history.php", function(data) {
		$(".history").empty();
        $.each(data.result, function () {
            var nama = this['nama_barang'];
            var jml = this['jumlah'];
            var role = this['role'];
            $(".history").append(function () {
                if (role == "BM") {
                    return '<li class="list-group-item">'+ nama +'<span class="badge text-bg-success">+' + jml + '</span></li>'
                } else{
                    return '<li class="list-group-item">'+ nama +'<span class="badge text-bg-danger">+' + jml + '</span></li>'
                } 
            });
		});
	});
}