<div class="#INNER_LEFT_PANEL#">
	<div class='#PANEL_CSS# #EVENT_ID#'>
		<div class="row"> 
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 #INNER_RIGHT_PANEL#'>
			 	#ROOM_IS_FULL_HTML#
			 	#STATUS_HTML#
				<small class='text-left makesmaller'><label class='#TRACK_LABEL#'>#TRACK#</label></small>
				<p class='text-left makesmaller sessionName'><b>#SESSION_NAME#</b></p>
				#SPEAKER_INFORMATION#				 					
			</div>
		</div>
		<div class='twitterPanel_#ROOM#'>
		#TWITTER#
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="#EVENT_ID#_MODAL" tabindex="-1" role="dialog" aria-labelledby="#EVENT_ID#_MODAL_LABEL" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header #INNER_MODAL_CSS#">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">#SESSION_NAME#</h4>
      </div>
      <div class="modal-body">
		<small class='text-left makesmaller'><label class='#TRACK_LABEL#'>#TRACK#</label></small>
	    <h4>Summary</h4>
	   	#SESSION_ABSTRACT#
	    <h5>Topics Covered</h5>
	   	#TOPICS#
	    <h4>Speaker(s)</h4>
	   	#SPEAKER_INFORMATION_MODAL#	
		<h4>More Information</h4>
		<ul>
			<li>#ROOM_NO#</li>
			<li>#TIME#</li>
		 	<li><a href="#PERMALINK#" target="_blank">View Full Details</a></li>
		</ul>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
$(".#PANEL_CSS#").on('mouseover',function(){
		$(this).addClass("eventOverlay");
});
$(".#PANEL_CSS#").on('mouseout',function(){
		$(this).removeClass("eventOverlay");
});
$(".#EVENT_ID#").on('click',function(){
		$('##EVENT_ID#_MODAL').modal('show');
});
</script>
