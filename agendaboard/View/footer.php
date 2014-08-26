
    </body>
</html>
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
});
</script>