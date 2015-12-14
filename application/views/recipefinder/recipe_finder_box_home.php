<script type="text/javascript">
function submit_form2()
{
  document.recipe_finder.submit();
}
</script>
<div class="searc-area">
        
            <form action="recipefinder/search"  name="recipe_finder" method="post" class="signup">
            <input type="hidden" name="tracker" id="tracker" value="0" />
            <fieldset>
            <span class="text"><span>
                 <input type="text" value="<? if(!empty($search)) echo $search;else echo "Search for a recipe";?>" name="search">
            </span></span> 
            <a class="sexybutton sexyorange sexybtn" href="javascript:submit_form2();"><span><span>Go</span></span></a>
            </fieldset>
            
        </form>
</div>   