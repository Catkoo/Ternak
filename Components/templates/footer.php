    <footer>
        <div class="copyright">
            <p>copyright Ternak Ayam Gesek Km.19 &copy; 2023</p>
        </div>
    </footer>


    <script src="assets/plugins/Jquery/jquery-3.6.0-min.js"></script>
    <script src="assets/plugins/bootstrap-5.2/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/fontawesome-free-6.1.1/js/all.min.js"></script>
    <script src="assets/plugins/DataTables/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.2/chart.min.js" integrity="sha512-zjlf0U0eJmSo1Le4/zcZI51ks5SjuQXkU0yOdsOBubjSmio9iCUp8XPLkEAADZNBdR9crRy3cniZ65LF2w8sRA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/script.js"></script>

    <script type="text/javascript">
        const labels = [
            'Barang Masuk',
            'Barang Keluar',
        ];
        const data = {
            labels: labels,
            datasets: [{
                label: 'My First dataset',
                backgroundColor: 'rgb(255, 99, 132)',
                backgroundColor: [
                    'rgb(54, 162, 235)',
                    'rgb(255, 99, 132)',
                ],s
                data: [<?= json_encode($dataBM);?>, <?= json_encode($dataBK);?>]
                    
            }]
        };
        const config = {
            type: 'pie',
            data: data,
            options: {}
        };
        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
</script>
</body>
</html>
