<div class="innerLeftColumn #INNER_LEFT_PANEL#">
	<div class='#PANEL_CSS# #EVENT_ID#' data-toggle="modal" data-target="##EVENT_ID#_MODAL">
		<div class="row">
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 innerRightColumn #INNER_RIGHT_PANEL#'>
			 	#ROOM_IS_FULL_HTML#
			 	#STATUS_HTML#

				<h4 class='text-left makesmaller sessionName'><b>#SESSION_NAME#</b></h4>
				#SPEAKER_INFORMATION#
				<label class='sessionTrack #TRACK_LABEL#'>#TRACK#</label>
			</div>
		</div>
		<div class='twitterPanel_#ROOM#'>
		#TWITTER#
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="#EVENT_ID#_MODAL" tabindex="-1" role="dialog" aria-labelledby="#EVENT_ID#_MODAL_LABEL" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header #INNER_MODAL_CSS#">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title sessionName">#SESSION_NAME#</h3>
      </div>
      <div class="modal-body">

	    <h4 class="sectionHeader">Summary</h4>
	   	#SESSION_ABSTRACT#
	    <h4  class="sectionHeader">Topics Covered</h4>
	    <label class='sessionTrack #TRACK_LABEL#'>#TRACK#</label>
	   	#TOPICS#
	   	<div class="row">
	   	 <div class="col-xs-6">
	   	   <h4 class="sectionHeader">Speaker(s)</h4>
    	   	#SPEAKER_INFORMATION_MODAL#
	   	 </div>
	   	 <div class="col-xs-6">
	   	   <h4 class="sectionHeader">More Information</h4>
      		<ul>
      			<li>#ROOM_NO#</li>
      			<li>#TIME#</li>
      		 	<li><a href="#PERMALINK#" target="_blank">View Full Details</a></li>
      		</ul>
	   	 </div>
	   	</div>


      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->