jQuery(document).ready(function(){
    var scripts = document.getElementsByTagName("script");
    var jsFolder = "";
    for (var i= 0; i< scripts.length; i++)
    {
        if( scripts[i].src && scripts[i].src.match(/initslider-1\.js/i))
            jsFolder = scripts[i].src.substr(0, scripts[i].src.lastIndexOf("/") + 1);
    }
    jQuery("#amazingslider-1").amazingslider({
        jsfolder:jsFolder,
        width:600,
        height:240,
        skinsfoldername:"",
        loadimageondemand:false,
        isresponsive:false,
        autoplayvideo:false,
        pauseonmouseover:true,
        addmargin:true,
        randomplay:false,
        playvideoonclickthumb:true,
        slideinterval:5000,
        enabletouchswipe:true,
        transitiononfirstslide:false,
        loop:0,
        autoplay:true,
        navplayvideoimage:"play-32-32-0.png",
        navpreviewheight:60,
        timerheight:2,
        descriptioncssresponsive:"font-size:12px;",
        shownumbering:false,
        skin:"FeatureList",
        textautohide:true,
        addgooglefonts:false,
        navshowplaypause:true,
        navshowplayvideo:false,
        navshowplaypausestandalonemarginx:8,
        navshowplaypausestandalonemarginy:8,
        navbuttonradius:0,
        navpreviewposition:"top",
        navmarginy:16,
        showshadow:false,
        navfeaturedarrowimagewidth:8,
        navpreviewwidth:120,
        googlefonts:"Inder",
        textpositionmarginright:24,
        bordercolor:"#ffffff",
        navthumbnavigationarrowimagewidth:32,
        navthumbtitlehovercss:"",
        texteffectresponsivesize:600,
        arrowwidth:32,
        texteffecteasing:"easeOutCubic",
        texteffect:"slide",
        navspacing:4,
        playvideoimage:"playvideo-64-64-0.png",
        ribbonimage:"ribbon_topleft-0.png",
        navwidth:70,
        navheight:70,
        arrowimage:"arrows-32-32-0.png",
        timeropacity:0.6,
        titlecssresponsive:"font-size:12px;",
        navthumbnavigationarrowimage:"carouselarrows-32-32-1.png",
        navshowplaypausestandalone:false,
        texteffect1:"slide",
        navpreviewbordercolor:"#ffffff",
        ribbonposition:"topleft",
        navthumbdescriptioncss:"display:block;position:relative;padding:2px 4px;text-align:left;color:#333;",
        navborder:3,
        navthumbtitleheight:18,
        textpositionmargintop:24,
        texteffectdelay:500,
        navswitchonmouseover:false,
        navarrowimage:"navarrows-28-28-0.png",
        arrowtop:50,
        textstyle:"static",
        playvideoimageheight:64,
        navfonthighlightcolor:"#666666",
        showbackgroundimage:false,
        navpreviewborder:4,
        navopacity:0.5,
        shadowcolor:"#aaaaaa",
        navbuttonshowbgimage:true,
        navbuttonbgimage:"navbuttonbgimage-28-28-0.png",
        navthumbnavigationarrowimageheight:32,
        textbgcss:"display:block; position:absolute; top:0px; left:0px; width:100%; height:100%; background-color:#333333; opacity:0.6; filter:alpha(opacity=60);",
        navpreviewarrowwidth:16,
        playvideoimagewidth:64,
        navshowpreviewontouch:false,
        bottomshadowimagewidth:110,
        showtimer:false,
        navradius:0,
        navshowpreview:false,
        navpreviewarrowheight:8,
        navmarginx:16,
        navfeaturedarrowimage:"featuredarrow-8-16-0.png",
        showribbon:false,
        navstyle:"thumbnails",
        textpositionmarginleft:24,
        descriptioncss:"display:block; position:relative; margin-top:8px;",
        navplaypauseimage:"navplaypause-28-28-0.png",
        backgroundimagetop:-10,
        timercolor:"#ffffff",
        numberingformat:"%NUM/%TOTAL ",
        navfontsize:12,
        navhighlightcolor:"#333333",
        texteffectdelay1:1000,
        navimage:"bullet-24-24-5.png",
        texteffectduration1:600,
        navshowplaypausestandaloneautohide:false,
        navbuttoncolor:"#999999",
        navshowarrow:true,
        texteffectslidedirection:"left",
        navshowfeaturedarrow:true,
        lightboxbarheight:48,
        titlecss:"display:block; position:relative;color:#fff;",
        ribbonimagey:0,
        ribbonimagex:0,
        texteffectslidedistance1:120,
        texteffectresponsive:true,
        navshowplaypausestandaloneposition:"bottomright",
        shadowsize:5,
        arrowhideonmouseleave:1000,
        navshowplaypausestandalonewidth:28,
        navfeaturedarrowimageheight:16,
        navshowplaypausestandaloneheight:28,
        backgroundimagewidth:120,
        navcolor:"#999999",
        navthumbtitlewidth:170,
        texteffectseparate:false,
        arrowheight:32,
        arrowmargin:8,
        texteffectduration:600,
        bottomshadowimage:"bottomshadow-110-95-4.png",
        border:6,
        timerposition:"bottom",
        navfontcolor:"#333333",
        navthumbnavigationstyle:"auto",
        borderradius:0,
        navbuttonhighlightcolor:"#333333",
        textpositionstatic:"bottom",
        navthumbstyle:"imageandtitledescription",
        texteffecteasing1:"easeOutCubic",
        textcss:"display:block; padding:12px; text-align:left;",
        navbordercolor:"#ffffff",
        navpreviewarrowimage:"previewarrow-16-8-0.png",
        showbottomshadow:false,
        texteffectslidedistance:120,
        navdirection:"vertical",
        textpositionmarginstatic:0,
        backgroundimage:"",
        navposition:"right",
        texteffectslidedirection1:"right",
        arrowstyle:"mouseover",
        textformat:"Bottom bar",
        bottomshadowimagetop:95,
        textpositiondynamic:"bottomleft",
        navshowbuttons:false,
        navthumbtitlecss:"display:block;position:relative;padding:2px 4px;text-align:left;color:#333;",
        textpositionmarginbottom:24,
        slice: {
            checked:true,
            effectdirection:0,
            effects:"up,down,updown",
            slicecount:10,
            duration:1500,
            easing:"easeOutCubic"
        },
        blocks: {
            columncount:5,
            checked:true,
            rowcount:5,
            effects:"topleft,bottomright,top,bottom,random",
            duration:1500,
            easing:"easeOutCubic"
        },
        slide: {
            duration:1000,
            easing:"easeOutCubic",
            checked:true,
            effectdirection:0
        },
        crossfade: {
            duration:1000,
            easing:"easeOutCubic",
            checked:true
        },
        threedhorizontal: {
            checked:true,
            effectdirection:0,
            bgcolor:"#222222",
            perspective:1000,
            slicecount:1,
            duration:1500,
            easing:"easeOutCubic",
            fallback:"slice",
            scatter:5,
            perspectiveorigin:"bottom"
        },
        fade: {
            duration:1000,
            easing:"easeOutCubic",
            checked:true
        },
        shuffle: {
            duration:1500,
            easing:"easeOutCubic",
            columncount:5,
            checked:true,
            rowcount:5
        },
        threed: {
            checked:true,
            effectdirection:0,
            bgcolor:"#222222",
            perspective:1000,
            slicecount:5,
            duration:1500,
            easing:"easeOutCubic",
            fallback:"slice",
            scatter:5,
            perspectiveorigin:"right"
        },
        blinds: {
            duration:2000,
            easing:"easeOutCubic",
            checked:true,
            effectdirection:0,
            slicecount:3
        },
        transition:"slice,blocks,slide,crossfade,threedhorizontal,fade,shuffle,threed,blinds",
        textformat: {

        }
    });
});