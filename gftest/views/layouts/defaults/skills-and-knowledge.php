<section class="container-fluid" id="skillSection">
    <div id="skillInner">
        <h1>MY SKILLS &amp; KNOWLEDGE </h1>
        <div class="row">
            <div class="col-md-12">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque rhoncus commodo. Aliquam erat volutpat. Maecenas vitae accumsan est, sed congue lorem. Donec imperdiet, dolor sit amet tempus tristique, tellus nisi consectetur velit, in laoreet mauris orci in metus. Donec pellentesque, orci a gravida pulvinar, orci nisl consectetur nisi, in volutpat lacus erat ac ante. 
                </p>
            </div> 
            <!-- START GRAPHICA -->
            <div class="col-md-12">
                <!-- <img src="" alt="Skills Graph"> -->
                    <h2>Personal skill graph:</h2>
                    <?php
                        include_once('gftest/models/KnowledgeModel.php');
                        
                        $knowledgeArray = $this->db->prepare('SELECT title, percent FROM knowledge')->execute()->fetchAllAssoc();
                        foreach ($knowledgeArray as $know) {
                            $knowledgeElement = new \Models\KnowledgeModel($know['title'], $know['percent']);
                            
                            echo $knowledgeElement->drawElement();
                        }
                    ?>
            </div> 
            <!-- END GRAPHICA -->
            
            <!-- START certificates button -->
            <a href="#" class="button-regular" data-toggle="modal" data-target="#myModal">CERTIFICATES</a>
            <!-- END certificates button -->
            
            <!-- START certificates modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Certificates</h4>
                        </div>
                        <div class="modal-body">
                            <ul id="certifactes">
                                <?php
                                    include_once('gftest/models/CertificateModel.php');
                                    
                                    $sertificatesArray = $this->db->prepare('SELECT title, href FROM certificates')->execute()->fetchAllAssoc();
                                    foreach ($sertificatesArray as $certificate) {
                                        $certificateElement = new \Models\CertificateModel($certificate['title'], $certificate['href']);
                                        
                                        echo $certificateElement->drawElement();                     
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END certificates modal -->
        </div>
    </div>
</section>