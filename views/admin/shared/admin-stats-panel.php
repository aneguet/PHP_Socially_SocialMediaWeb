<?php
$a = new AdminController();
$stats = $a->getAdminDashboardStats();
$i = 0;
?>
<div class="row">
    <div class="my-3">
        <section id="totalStats">
            <h4 class="text-muted secondary-header-margin">Stats</h4>
            <div class="d-flex justify-content-around">
                <div class="col-sm-2">
                    <div class="card border-left border-primary shadow">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs weight-bold text-uppercase">
                                        Users
                                    </div>
                                    <div class="font-weight-bold text-uppercase">
                                        <h5><?php echo $stats[$i][0] ?? 0; //Null coalescing operator: It returns its first operand if it exists and is not null; otherwise it returns its second operand
                                            $i++; ?></h5>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="card border-left border-primary shadow">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs weight-bold text-uppercase">
                                        Posts
                                    </div>
                                    <div class="font-weight-bold text-uppercase">
                                        <h5><?php echo $stats[$i][0] ?? 0;
                                            $i++; ?></h5>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-paragraph fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="card border-left border-primary shadow">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs weight-bold text-uppercase">
                                        Comments
                                    </div>
                                    <div class="font-weight-bold text-uppercase">
                                        <h5><?php echo $stats[$i][0] ?? 0;
                                            $i++; ?></h5>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="card border-left border-primary shadow">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs weight-bold text-uppercase">
                                        Upvotes
                                    </div>
                                    <div class="font-weight-bold text-uppercase">
                                        <h5><?php echo $stats[$i][0] ?? 0;
                                            $i++; ?></h5>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-arrow-up fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="card border-left border-primary shadow">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs weight-bold text-uppercase">
                                        Downvotes
                                    </div>
                                    <div class="font-weight-bold text-uppercase">
                                        <h5><?php echo $stats[$i][0] ?? 0;
                                            $i++; ?></h5>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-arrow-down fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>