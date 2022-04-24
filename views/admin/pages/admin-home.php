<div class="d-flex justify-content-between flex-wrap align-items-center">
    <h1>Admin Dashboard</h1>
</div>
<!-- Graphs section -->
<div class="row">
    <div class="my-3">
        <section id="graphs">
            <h4 class="text-muted secondary-header-margin">Graphs</h4>
            <div class="d-flex justify-content-around">
                <div class="col-md-5">
                    <div class="card mb-4 shadow">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            New users
                        </div>
                        <div class="card-body"><canvas id="myLineChart" width="100%" height="80"></canvas></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Posts per category
                        </div>
                        <div class="card-body"><canvas id="myPieChart" width="100%" height="80"></canvas></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<?php echo '<script src="' . PATH . 'views/admin/js/charts.js"></script>'; ?>