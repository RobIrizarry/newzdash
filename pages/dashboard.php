	<!-- breadcrumbs end -->
	<div class="breadcrumb">
		<h2>NewzDash Main Monitor</h2><hr style="color:#000000; background-color:#000000; height:3px;">
		
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="5%">
					<div align="center"><strong>Log ID</strong></div>
				</td>
				<td width="50%">
					<div align="center"><strong>Pane Name</strong></div>
				</td>
				<td width="30%">
					<div align="center"><strong>State</strong></div>
				</td>
				<td>
					<div align="center"><strong>Time Date</strong></div>
				</td>
			</tr>
		</table>
				
		<div id="list" style="overflow:scroll; overflow-x:hidden; height:100px;">
        </div>
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
		
		<a data-rel="tooltip" title="Versions" class="well span4 top-block" href="#">
			<?php $dashdata->getDatabaseAndRegexInfo(); ?>
		</a>
		
		<a data-rel="tooltip" title="Last Update Duration" class="well span4 top-block" href="#">
			<span class="icon32 icon-blue icon-clock"></span>
			<div>Last Update Duration</div>
			<div id="lastupdateduration">Loading...</div>
		</a>
		
	</div>

	<!-- Version summaries start -->
	<div class="row-fluid">
		
		<a data-rel="tooltip" title="Subversion" class="well span4 top-block" href="#">
			<span class="icon32 icon-blue icon-info"></span>
			<div>NewzNab</div>
			<div id="newznabversion">Loading...</div>
		</a>
		
		<a data-rel="tooltip" title="NewzNab-tmux" class="well span4 top-block" href="#">
			<span class="icon32 icon-blue icon-info"></span>
			<div>NewzNab-tmux</div>
			<div id="newznabtmuxversion">Loading...</div>
		</a>

		<a data-rel="tooltip" title="NewzDash" class="well span4 top-block" href="#">
			<span class="icon32 icon-blue icon-info"></span>
			<div>NewzDash</div>
			<div id="newzdashversion">Loading...</div>
		</a>
	</div>
	<!-- Version summaries end -->
