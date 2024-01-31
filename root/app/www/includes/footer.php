<?php

/*
----------------------------------
 ------  Created: 012724   ------
 ------  Austin Best	   ------
----------------------------------
*/

?>

            </div>
        </div>
        <!-- Toast -->
        <div class="toast-container end-0 bottom-0 p-3" style="z-index: 10000 !important; position: fixed;"></div>

        <!-- Generic modal -->
        <div id="dialog-modal-container">
            <div class="modal fade" id="dialog-modal" style="z-index: 9999 !important;" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content bg-dark" style="border: grey solid 1px;">
                        <div class="modal-header" style="border: grey solid 1px;">
                            <h5 class="modal-title"></h5>
                            <i class="far fa-window-close fa-2x" data-bs-dismiss="modal" style="cursor: pointer;"></i>
                        </div>
                        <div class="modal-body" data-scrollbar=”true” data-wheel-propagation=”true”></div>
                        <div class="modal-footer"></div>
                    </div>
                </div>
            </div>
        </div>

        <script src="libraries/jquery/jquery.min.js" type="text/javascript"></script>
        <script src="libraries/jquery/jquery-ui-1.13.2.min.js" type="text/javascript"></script>
        <script src="assets/vendors/js/vendor.bundle.base.js"></script>
        <script src="assets/vendors/chart.js/Chart.min.js"></script>
        <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
        <script src="assets/js/off-canvas.js"></script>
        <script src="assets/js/hoverable-collapse.js"></script>
        <script src="<?= RELATIVE_PATH ?>js/common.js?t=<?= filemtime(RELATIVE_PATH . 'js/common.js') ?>" type="text/javascript"></script>
        <script src="<?= RELATIVE_PATH ?>js/git.js?t=<?= filemtime(RELATIVE_PATH . 'js/git.js') ?>" type="text/javascript"></script>
    </body>
</html>
