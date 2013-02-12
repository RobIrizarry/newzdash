	<!-- breadcrumbs end -->
	<div class="breadcrumb">
		<h2>NewzDash Main Monitor</h2><hr style="color:#000000; background-color:#000000; height:3px;"><br />
		Most notification panes are updated automatically every <?php echo ( JSUPDATE_DELAY/1000 . " seconds."); ?><br /><br />
		<strong>This is Alpha Software, while it does not write to your database, it does read from it - use at your own risk!</strong>
	</div>
	
	<!-- Count Dashboard summaries start -->
	<div class="row-fluid">
		<a data-rel="tooltip" title="Total Releases" class="well span4 top-block" href="#">
			  <?php //$dashdata->getReleaseCount(); ?>
			  <span class="icon32 icon-blue icon-star-on"></span>
		<div>Total Releases</div>
		<div id="releaseCount">Loading...</div>
			  
		</a>

		<a data-rel="tooltip" title="Active Groups" class="well span4 top-block" href="#">
			  <?php //$dashdata->getActiveGroupCount(); ?>
			  <span class="icon32 icon-blue icon-comment"></span>
				<div>Active Groups</div>
				<div id="activegroups">Loading...</div>
		</a>

		<a data-rel="tooltip" title="Release Pending Post-Processing" class="well span4 top-block" href="#">
			<?php //echo $dashdata->getPendingProcessingCount(); ?>
			
			<span class="icon32 icon-blue icon-star-off"></span>
			<div>Pending Processing</div>
			<div id="pendingprocessing">Loading...</div>
		</a>


	</div>
	<!-- Dashboard summaries end -->

	<!-- Date summaries start -->
	<div class="row-fluid">
		
		<a data-rel="tooltip" title="Last Group Update" class="well span4 top-block" href="#">
			<?php //$dashdata->getLastGroupUpdate(); ?>
			<span class="icon32 icon-blue icon-clock"></span>
			<div>Last Group Update</div>
			<div id="lastgroupupdate">Loading...</div>
		</a>
		
		<a data-rel="tooltip" title="Last Binary Added" class="well span4 top-block" href="#">
			<?php //$dashdata->getLastBinaryAdded(); ?>
			<span class="icon32 icon-blue icon-clock"></span>
			<div>Last Binary Added</div>
			<div id="lastbinaryadded">Loading...</div>
		</a>

		<a data-rel="tooltip" title="Last Release Created" class="well span4 top-block" href="#">
			<?php //$dashdata->getLastReleaseCreated(); ?>
			<span class="icon32 icon-blue icon-clock"></span>
			<div>Last Release Created</div>
			<div id="lastreleasecreated">Loading...</div>
		</a>
	</div>
	<!-- Date summaries end -->		

	<div class="row-fluid">
		<a data-rel="tooltip" title="Subversion" class="well span4 top-block" href="#">
			<span class="icon32 icon-blue icon-gear"></span>
			<div>Parts Table Stats</div>
			<div id="partstablestats">Loading...</div>
		</a>
		<a data-rel="tooltip" title="Subversion" class="well span4 top-block" href="#">
			<span class="icon32 icon-blue icon-gear"></span>
			<div>Placeholder</div>
			<div id="unknown">0000</div>
		</a>
		<a data-rel="tooltip" title="Subversion" class="well span4 top-block" href="#">
			<span class="icon32 icon-blue icon-gear"></span>
			<div>Placeholder</div>
			<div id="unknown">0000</div>
		</a>
		
	</div>

	<!-- Version summaries start -->
	<div class="row-fluid">
		
		<a data-rel="tooltip" title="Subversion" class="well span4 top-block" href="#">
			<?php $dashdata->getSubversionInfo(); ?>
		</a>
		
		<a data-rel="tooltip" title="Versions" class="well span4 top-block" href="#">
			<?php $dashdata->getDatabaseAndRegexInfo(); ?>
		</a>

		<a data-rel="tooltip" title="NewzDash" class="well span4 top-block" href="#">
			<?php $dashdata->getNewzDashInfo(); ?>
		</a>
	</div>
	<!-- Version summaries end -->