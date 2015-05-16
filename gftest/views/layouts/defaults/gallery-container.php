<section class="container-fluid" id="gallerySection">
    <div class="row">
    <!-- GALERY HERE -->
        <section class="col-md-12 project-gallery">
            <?php
                include_once('gftest/models/ProjectModel.php');
                
                $projectsArray =
                    $this->db->prepare('SELECT id, title, content, demo, github, projecttype, projectimage FROM projects')->execute()->fetchAllAssoc();
                foreach ($projectsArray as $project) {
                    $projectModel = new \Models\ProjectModel($project['id'], $project['title'], $project['content'],
                        $project['projectimage'], $project['projecttype'], $project['github'], $project['demo']);
                        
                    echo $projectModel->drawElement();
                }
            ?>
			<!--
				PROJECT FOR JS:
				
				<div class="project-item">
                    <img class="imageshow" src="img/uni-bio.jpg" alt="">
                    <div class="projectInfo"> 
                        <span class="typeofWork">WEBSITE</span>
                        <h4 class="projectName">Paisii Hilendarski BIO faculty</h4>
                    </div>
                    <a class="seemore" href="#" data-toggle="modal" data-target="#myModal1"><img src="img/seemore.png" alt=""></a>
                    <a class="link" href="#"><img src="img/link.png" alt=""></a>
                </div>
			-->
			<!-- MODAL HERE -->
			<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog gallery-modal">
                    <div class="modal-content">
						<!--
							MODAL FOR JS:
							
							<div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">Уебсайт проект за биологичен факултет на ПУ</h4>
                            </div>
                            <div class="modal-body">
                                <img src="img/uni-bio.jpg">
                                <p>Биологическият факултет провежда обучение и изследвания в различни биологични направления и понастоящем има седем катедри (Анатомия и физиология на човека.</p>
                            </div>
                            <div class="modal-footer">
                                <a href="http://bio-uni-plovdiv.com/?headinfo=1">click to see the project</a>
                            </div>
						-->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel"></h4>
                            </div>
                            <div class="modal-body">
                                <img />
                                <p></p>
                            </div>
                            <div class="modal-footer">
                                <a>click to see the project</a>
                            </div>
                            <input type="hidden" class="clickedProjectData" />
					</div>
				</div>
			</div>
			<!-- MODAL -->
		</section>
	</div>
</section>