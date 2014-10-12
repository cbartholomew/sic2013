  <div class='logoFooter'>
		<?php
			print("<img src='" . $headerImage . "' alt='2013-branding-A' class='' />");
		?>
  </div>
</div><!--end .container-->
    <script>

      function refreshWebPanel() {
      	window.location.reload(true);
      }

      function goToActiveRow() {
      	window.location.href = "#ACTIVE";
      }

      function unbindNoSession()
      {
      	$(".999").unbind("mouseover");
          $(".999").unbind("mouseout");
      	$(".999").unbind("click");
      }

      $(document).ready(function(){
      	goToActiveRow();
      	setTimeout(refreshWebPanel,120000);
      	unbindNoSession();
      	$('table').floatThead();
      	//$('.mypanel_inactive').css("opacity", .5);

      	//disable modals on inactive sessions
      	$('.mypanel_inactive').click(function(){
        	return false;
      	})
      });
    </script>

  </body>
</html>
