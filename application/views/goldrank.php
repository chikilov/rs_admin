<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Content -->
<div class="content content-boxed">
    <!-- All Orders -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">골드 랭킹</h3>
        </div>
        <div class="block-content">
            <table class="table table-borderless table-striped table-vcenter" id="goldrank">
                <thead>
                    <tr>
                        <th class="text-center">UID</th>
                        <th class="text-center">수량</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">
                            -
                        </td>
                        <td class="text-center">
                            -
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END All Orders -->
</div>
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->
<!--<script src="<?php echo $one->assets_folder; ?>/js/plugins/chartjs/Chart.min.js"></script>-->
<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/goldrank.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>