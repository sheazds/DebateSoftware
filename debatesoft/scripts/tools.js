$(document).ready(function(){
    var currentSection = null;
    $("#reports").click(function(){
        openSection(currentSection, "reports");
        currentSection = "reports";
    });

    function openSection(currentSection, newSection)
    {
        if (currentSection != null)
        {
            $("#"+currentSection+"_section").find(".section_content").empty();
            $("#"+currentSection+"_section").attr("class", "reg_section closed");
        }
        $("#"+newSection+"_section").find(".section_content").load("tools/"+newSection+".php");
        $("#"+newSection+"_section").attr("class", "reg_section open");
    }
});