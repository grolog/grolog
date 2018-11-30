if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function (obj, start) {
        for (var i = (start || 0), j = this.length; i < j; i++) {
            if (this[i] === obj) {
                return i;
            }
        }
        return -1;
    }
}

(function(){IP_init();})();


function IP_loadjscssfile(filename, filetype){
    if (filetype=="js"){ /*if filename is a external JavaScript file*/
        var fileref=document.createElement('script');
        fileref.setAttribute("type","text/javascript");
        fileref.setAttribute("src", filename);
    }
    else if (filetype=="css"){ /*if filename is an external CSS file*/
        var fileref=document.createElement("link");
        fileref.setAttribute("rel", "stylesheet");
        fileref.setAttribute("type", "text/css");
        fileref.setAttribute("href", filename);
    }
    if (typeof fileref!="undefined")
        document.getElementsByTagName("head")[0].appendChild(fileref);
}
 

IP_loadjscssfile(window.location.protocol+"//services.iperfect.net/js/IP_calendar.js", "js"); /*dynamically load "javascript.php" as a JavaScript file*/
IP_loadjscssfile(window.location.protocol+"//services.iperfect.net/js/IP_calendar.css", "css"); /*dynamically load and add this .css file*/
//
//IP_loadjscssfile(window.location.protocol+"//services.iperfect.net/js/IP_general.css", "css"); /*dynamically load and add this .css file*/

function IP_blurElement(IDelement, size) {
    
    var filterVal = 'blur(' + size + 'px)';
    document.getElementById(IDelement).style = "filter:" + filterVal + ";webkitFilter:" + filterVal + ";mozFilter:" + filterVal + ";oFilter:" + filterVal + ";msFilter:" + filterVal;
}

function IP_init(){
   
    window.onload = function () { 
        var obj = document.createElement("div");
        obj.id = "IP_loading";
         
        document.getElementsByTagName("body")[0].appendChild(obj);
        document.getElementById("IP_loading").innerHTML="<img id='IP_loading_img' src='http://services.iperfect.net/js/img/loading.gif' alt='Loading...' />";
		IP_loading(0);
	}
    
}

function IP_loading(num) {
    if (num == 1) {
        document.getElementById('IP_loading').style = 'display: block;';
    } else
    {
        document.getElementById('IP_loading').style = 'display: none;';
    }
}

function IP_getRandomNumber(len){
  return Math.floor(Math.random() * Math.pow(6, len));
}
var IP_editrow,IP_undorow,IP_saverow,IP_deleterow;
var IP_persistValue = new Array();
    IP_persistValue[0]= new Array();
function IP_gridReadWrite(IP_grid_config,IP_grid_arr,IP_jsonObj,divID){
   
   
    var getUID = IP_getRandomNumber(5);
    var editablefield = IP_grid_config[0]["editable_field"];
    var tooltipfield = IP_grid_config[0]["tooltip_field"];
    var saveURL = IP_grid_config[0]["save_url"];
    var deleteURL = IP_grid_config[0]["delete_url"];
    var IP_fieldname;
    var IP_html="Total records : " + (IP_jsonObj.length) + "<br>";
    IP_html+="<table class='"+IP_grid_config[0]["tableClass"]+"'><tr>";

    for(var i=0;i<IP_grid_arr.length;i++){
    if(i==0){
        IP_html+="<thead class='"+IP_grid_config[0]["theadClass"]+"'>";
    for( var data in IP_grid_arr[0]){
    IP_html+="<th>"+data+"</th>";
    }
    

    
    IP_html+="</thead><tbody class='"+IP_grid_config[0]["tbodyClass"]+"'>";
    for(var j=0;j<IP_jsonObj.length;j++){
    IP_html+="<tr>";
    for( var data in IP_grid_arr[0]) {
                            try{
                            var primary_key =IP_grid_config[0]["primery_key"];    
                            var primary_key_value =eval("IP_jsonObj[j]." +IP_grid_config[0]["primery_key"]);    
                            IP_fieldname = IP_grid_arr[0][data];
                            
                            var link_cell_function="";
                            if(IP_grid_config[0]["link_cell_function"]!=undefined){
                                if(IP_grid_config[0]["link_cell_function"]!=""){
                                    link_cell_function = "onclick="+IP_grid_config[0]["link_cell_function"]+"('"+IP_fieldname+"|"+primary_key_value+"'); onmouseover=this.style.cursor='pointer'";
                                }
                            }
                           
                           
                            if(tooltipfield.indexOf(IP_fieldname)==-1){
                            IP_html += "<td class='"+IP_fieldname + "_"+IP_grid_config[0]["tdClass"]+"' id='"+IP_fieldname+"_"+primary_key_value+"_"+getUID+"' "+link_cell_function+">" + eval("IP_jsonObj[j]." + IP_fieldname) + "</td>";
                            }else{
                                IP_html += "<td class='"+IP_fieldname + "_"+IP_grid_config[0]["tdClass"]+"' id='"+IP_fieldname+"_"+primary_key_value+"_"+getUID+"' "+link_cell_function+"><div class='"+IP_fieldname + "_"+IP_grid_config[0]["tooltipClass"]+"'>" + eval("IP_jsonObj[j]." + IP_fieldname) + "<span class='"+IP_fieldname + "_"+IP_grid_config[0]["tooltipClass"]+"_text'>" + eval("IP_jsonObj[j]." + IP_fieldname) + "</span></div></td>";
                            }
                            }catch(err){
                                if(IP_grid_config[0]["chmod"]=="7"){
                                    IP_html += "<td><input type='button' class='"+IP_grid_config[0]["btnClass"]+"' name='btnEdit' id='IP_btn_edit_"+primary_key_value+"_"+getUID+"' value='Edit' onclick=IP_editrow('"+primary_key_value+"_"+getUID+"','"+editablefield+"','"+primary_key+"','"+primary_key_value+"','"+saveURL+"')>";
                                    IP_html += "<input type='button' class='"+IP_grid_config[0]["btnClass"]+"'  name='btnDelete' id='IP_btn_delete_"+primary_key_value+"_"+getUID+"' value='Del' onclick=IP_deleterow('"+primary_key_value+"_"+getUID+"','"+editablefield+"','"+primary_key+"','"+primary_key_value+"','"+deleteURL+"')>";    
                                }else if(IP_grid_config[0]["chmod"]=="6"){
                                    IP_html += "<td><input type='button' class='"+IP_grid_config[0]["btnClass"]+"' name='btnEdit' id='IP_btn_edit_"+primary_key_value+"_"+getUID+"' value='Edit' onclick=IP_editrow('"+primary_key_value+"_"+getUID+"','"+editablefield+"','"+primary_key+"','"+primary_key_value+"','"+saveURL+"')>";
                                    IP_html += "<input type='hidden' class='"+IP_grid_config[0]["btnClass"]+"' name='btnDelete' id='IP_btn_delete_"+primary_key_value+"_"+getUID+"' value='Del' onclick=IP_deleterow('"+primary_key_value+"_"+getUID+"','"+editablefield+"','"+primary_key+"','"+primary_key_value+"','"+deleteURL+"')>";    
                                }
                                IP_html += "</td>";    
                            }
                        }
                        IP_html += "</tr>";
                    }
                }
            }
            
            var customEditField = "";
            var customUndoField = "";
            if(IP_grid_config[0]["chmod"]=="6"){
                customEditField = 'document.getElementById("IP_btn_delete_"+uid).type="button";';
                customUndoField = 'document.getElementById("IP_btn_delete_"+uid).type="hidden";';
            }
            
            IP_html += "</tr></tbody>";

            document.getElementById(divID).innerHTML = IP_html;
           
            var before_save_event="";
            if(IP_grid_config[0]["before_save_event"]!==undefined){
                if(IP_grid_config[0]["before_save_event"]!==""){
                    before_save_event = 'if(!'+IP_grid_config[0]["before_save_event"]+'(uid)){return;}';
                }
            }
            
            
            var editfield = 'var arr = editablefield.split(","); for(var st in arr){ IP_persistValue[0][arr[st]+"_"+uid]=document.getElementById(arr[st]+"_"+uid+"").innerHTML; document.getElementById(arr[st]+"_"+uid+"").innerHTML="<input type=text id=edited_"+arr[st]+"_"+uid+" value=\'"+document.getElementById(arr[st]+"_"+uid+"").innerHTML+"\' >"} document.getElementById("IP_btn_edit_"+uid).value="Save";document.getElementById("IP_btn_delete_"+uid).value="Cancel"; '+customEditField+' document.getElementById("IP_btn_edit_"+uid).onclick = function(){ IP_saverow(uid,editablefield,primary_key,primary_key_value,saveURL); } ;document.getElementById("IP_btn_delete_"+uid).onclick = function(){ IP_undorow(uid,editablefield,primary_key,primary_key_value,saveURL); } ;';
            var undofield = 'var arr = editablefield.split(","); for(var st in arr){ document.getElementById(arr[st]+"_"+uid+"").innerHTML=IP_persistValue[0][arr[st]+"_"+uid];} document.getElementById("IP_btn_edit_"+uid).value="Edit";document.getElementById("IP_btn_delete_"+uid).value="Del";'+customUndoField+' document.getElementById("IP_btn_edit_"+uid).onclick = function(){ IP_editrow(uid,editablefield,primary_key,primary_key_value,saveURL); } ;document.getElementById("IP_btn_delete_"+uid).onclick = function(){ IP_deleterow(uid,editablefield,primary_key,primary_key_value,saveURL); } ;';
            
            var savefield = 'var querystring=""; '+before_save_event+' var arr = editablefield.split(",");  for(var st in arr){ var edited_value = document.getElementById("edited_"+arr[st]+"_"+uid+"").value; querystring+="&"+arr[st]+"="+edited_value; document.getElementById(arr[st]+"_"+uid+"").innerHTML=edited_value}  document.getElementById("IP_btn_edit_"+uid).value="Edit";'+customUndoField+'document.getElementById("IP_btn_delete_"+uid).value="Del"; document.getElementById("IP_btn_edit_"+uid).onclick = function(){ IP_editrow(uid,editablefield,primary_key,primary_key_value,saveURL); }; IP_callURL(saveURL+"?"+primary_key+"="+primary_key_value+"&"+querystring+"&IP_type=edit","","html",IP_onSaved); document.getElementById("IP_btn_delete_"+uid).onclick = function(){ IP_deleterow(uid,editablefield,primary_key,primary_key_value,saveURL); } ;';
            var deleterow = 'if(confirm("Are you sure you want to delete this?")){ IP_callURL(deleteURL+"?"+primary_key+"="+primary_key_value+"&IP_type=delete","","html",IP_onDeleted); };';
            
             IP_editrow = new Function('uid,editablefield,primary_key,primary_key_value,saveURL',editfield);
             IP_undorow = new Function('uid,editablefield,primary_key,primary_key_value,saveURL',undofield);
             IP_saverow = new Function('uid,editablefield,primary_key,primary_key_value,saveURL',savefield);
             IP_deleterow = new Function('uid,editablefield,primary_key,primary_key_value,deleteURL',deleterow);     
             
             return getUID;
    }


function IP_gridReadOnly(IP_grid_arr,IP_jsonObj,divID){
   
    var IP_fieldname;
    var IP_html="Total records : " + (IP_jsonObj.length) + "<br>";
    IP_html+="<table border=1 style='width:100%'><tr>";

    for(var i=0;i<IP_grid_arr.length;i++){
    if(i==0){
    for( var data in IP_grid_arr[0]){
    IP_html+="<th>"+data+"</th>";
    }
    for(var j=0;j<IP_jsonObj.length;j++){
    IP_html+="<tr>";
    for( var data in IP_grid_arr[0]) {
                            IP_fieldname = IP_grid_arr[0][data];
                            IP_html += "<td>" + eval("IP_jsonObj[j]." + IP_fieldname) + "</td>";
                        }
                        IP_html += "</tr>";
                    }
                }
            }
            IP_html += "</tr>";
            document.getElementById(divID).innerHTML = IP_html;
    }


var IP_objtimer = [];
var IP_objTimerCount = 0;
function IP_sleep(num,func){
  var  IP_objTimerCountCurrent = ++IP_objTimerCount;
   IP_objtimer[IP_objTimerCountCurrent] =  setTimeout(function (){
        console.log("IP_sleep trigger ID:"+IP_objTimerCountCurrent);
        func();
    },num);
    return IP_objTimerCountCurrent;
}

function IP_timer(num,func){
     var IP_objTimerCountCurrent = ++IP_objTimerCount;
    IP_objtimer[IP_objTimerCountCurrent] = setInterval(function (){
        console.log("IP_timer trigger ID:"+IP_objTimerCountCurrent);
        func();
    },num);
    return IP_objTimerCountCurrent;
}

function IP_destorySleepTimer(IP_objTimerID){
    clearInterval(IP_objtimer[IP_objTimerID]);
}

function IP_isAlpha(str) {
    return /^[a-zA-Z]+$/.test(str);
}
function IP_dateDiff(date1,date2,Dateformat,debug){
var day1="",month1 = "", year1 = "", day2 = "", month2 = "", year2 = "";
        var delimeter = "";
        for (var i = 0; i < Dateformat.length; i++) {
            if (IP_isAlpha(Dateformat.charAt(i))) {

                switch (Dateformat.charAt(i).toLowerCase()) {
                    case 'd':
                    {
                        day1 += date1.charAt(i);
                        day2 += date2.charAt(i);
                        break;
                    }
                    case 'm':
                    {
                        month1 += date1.charAt(i);
                        month2 += date2.charAt(i);
                        break;
                    }
                    case 'y':
                    {
                        year1 += date1.charAt(i);
                        year2 += date2.charAt(i);
                        break;
                    }
                }

            }
            else {
                delimeter = Dateformat.charAt(i);
            }
        }

        var d1 = new Date(parseInt(year1), parseInt(month1) - 1, parseInt(day1));
        var d2 = new Date(parseInt(year2), parseInt(month2) - 1, parseInt(day2));
        var timeDiff = d2.getTime() - d1.getTime();
        var DaysDiff = timeDiff / (1000 * 3600 * 24);
        if(debug==true){
            alert(DaysDiff);
        }
        return DaysDiff;
    }
function IP_uploadFile(URL, responseType,fileobj,func) {
    var allowAjaxCall=true;
    var xmlhttp = false;
    if (window.XMLHttpRequest)
    {/* code for IE7+, Firefox, Chrome, Opera, Safari*/
        xmlhttp = new XMLHttpRequest();
    }
    else
    {/* code for IE6, IE5*/
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open("POST", URL, true);
 
    xmlhttp.send(new FormData(fileobj));
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState = 4 && xmlhttp.status == 200 && allowAjaxCall) {
            if (xmlhttp.responseText != "") {
                allowAjaxCall = false;
               switch(responseType){
                    case 'html':
                    {
                        func(xmlhttp.responseText);
                        break;
                    }
                    case 'json':
                    {
                        func(JSON.parse(xmlhttp.responseText));
                        break;
                    }
                }
            }
        }
    }
}
function IP_rtrim(stringToTrim) {
    return stringToTrim.replace(/\s+$/, "");
}
function IP_getQueryParams(url) {
   var vars = {};
    if(url==undefined){
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) { vars[key] = value; });   
    }else{
        var parts = url.replace(/[?&]+([^=&]+)=([^&]*)/gi,  function(m,key,value) { vars[key] = value; });  
    }
    return vars;
}
function IP_callURL(URL, arrPost, responseType,func, func_before_save) {
    var flg;
    if(func_before_save==undefined){
       flg = true;
    }
    else{
        if(arrPost.length==0){
            var param = IP_getQueryParams(URL);
        }else{
           var param = arrPost;
        }
        flg = func_before_save(param);
        
    }
    if(!flg){
        return;
    }
    var allowAjaxCall=true;
    var xmlhttp = false;
    if (window.XMLHttpRequest)
    {/* code for IE7+, Firefox, Chrome, Opera, Safari*/
        xmlhttp = new XMLHttpRequest();
    }
    else
    {/* code for IE6, IE5*/
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open("POST", URL, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "";
    for (var key in arrPost) {
        data = data + key + "=" + arrPost[key] + "&";
    }
    data = IP_rtrim(data);
    
    IP_loading(1);
    xmlhttp.send(data);

    xmlhttp.onreadystatechange = function ()
    {   
         if (xmlhttp.readyState = 4 && xmlhttp.status == 200 && allowAjaxCall) {
             
            if (xmlhttp.responseText != "") {
                try{
                    
                switch(responseType){
                    case 'html':
                    {
                        func(xmlhttp.responseText);
                        break;
                    }
                    case 'json':
                    {
                        func(JSON.parse(xmlhttp.responseText));
                        break;
                    }
                }
                allowAjaxCall = false;
                IP_loading(0);
                }catch(err) {
                    allowAjaxCall = true;
                }            
            }
        }
       
    }
}

function IP_toggleAllCheckbox(obj,name){
    var objCheckbox = document.getElementsByName(name);
    for(var i=0;i<objCheckbox.length;i++){
        if(obj.checked==true){
            objCheckbox[i].checked= true;
        }else{
            objCheckbox[i].checked= false;
        }
    }   
}




/*Iperfect Standard library for autocomplete starts*/
function IP_keyCheckForAutoComplete(ID, e) {
    var key = e.which || e.keyCode;

    switch (key) { /* 13 is enter*/
        case 13:
            {
                document.getElementById(ID).value = document.getElementById("IP_temp_listBox").value;
                var elem = document.getElementById("IP_temp_listBox");
                elem.parentNode.removeChild(elem);
                document.getElementById(ID).focus();
                break;
            }
        case 27:
            {
                var elem = document.getElementById("IP_temp_listBox");
                elem.parentNode.removeChild(elem);
                document.getElementById(ID).focus();
                break;
            }
    }
}

function IP_autoCompleteProcess(ID,IDDiv, e, data,className) {
    var d = document.getElementById(IDDiv);

    var fieldWidth = d.offsetWidth;
    var topPos = d.offsetTop;
    var leftPos = d.offsetLeft;
    var topPos = d.offsetTop + d.offsetHeight;

/*selection event starts*/
    e = e || window.event;
    if (e.keyCode == '38') {
/* up arrow*/
    }
    else if (e.keyCode == '40') {
/* down arrow*/
        if (document.getElementById("IP_temp_listBox")) {
            document.getElementById("IP_temp_listBox").focus();
            document.getElementById("IP_temp_listBox").selectedIndex = 0;
            document.getElementById("IP_temp_listBox").addEventListener("keypress", function(e) {
                IP_keyCheckForAutoComplete(ID, e);
            });

            return;
        }
    }
    else if (e.keyCode == 13){
        return;
    }

/*check on blank field*/

    var str = document.getElementById(ID).value;
    if ((str == "" && document.getElementById("IP_temp_listBox")) || (data.length == 0 && document.getElementById("IP_temp_listBox"))) {
        var elem = document.getElementById("IP_temp_listBox");
        elem.parentNode.removeChild(elem);
        return;
    }

    var objNewElement;
    var option;
    if (document.getElementById("IP_temp_listBox")) {
        var objNewElement = document.getElementById("IP_temp_listBox");
        document.getElementById("IP_temp_listBox").options.length = 0;

    } else {
        var objNewElement = document.createElement("select");
    }

    objNewElement.size = 5;
    objNewElement.id = "IP_temp_listBox";
    /*objNewElement.offsetTop = topPos;*/
    /*objNewElement.offsetLeft = leftPos;*/
    
    objNewElement.style.position='absolute';
    objNewElement.style.top=topPos;
    objNewElement.style.left=leftPos;
    objNewElement.style.width=fieldWidth;
    
    /*objNewElement.style = "position: absolute;top:" + topPos + ";left:" + leftPos + ";width:" + fieldWidth;*/
    if(className==undefined){
    /*objNewElement.className = className;*/
    }else{
    objNewElement.className = className;
    }
    for (var i = 0; i < data.length; i++) {
        option = document.createElement("option");
        option.text = data[i];
        option.value = data[i];
        objNewElement.add(option);
    }
    document.body.appendChild(objNewElement);
    document.getElementById("IP_temp_listBox").addEventListener("click", function(e) {
        document.getElementById(ID).value = document.getElementById("IP_temp_listBox").value;
        var elem = document.getElementById("IP_temp_listBox");
        elem.parentNode.removeChild(elem);
        document.getElementById(ID).focus();
    });
    document.getElementById("IP_temp_listBox").addEventListener("blur", function(e) {
        if (document.getElementById("IP_temp_listBox")) {
            var elem = document.getElementById("IP_temp_listBox");
            elem.parentNode.removeChild(elem);
            document.getElementById(ID).focus();
        }
    });
    document.getElementById(ID).addEventListener("blur", function(e) {

        setTimeout(function() {
            if (!(document.getElementById("IP_temp_listBox") === document.activeElement)) {
                if (document.getElementById("IP_temp_listBox")) {
                    var elem = document.getElementById("IP_temp_listBox");
                    elem.parentNode.removeChild(elem);
                    return;
                }
                return;
            }


        }, 100);
    });
}

function IP_autoComplete(URL, ID,IDDiv, e,className)
{
    var responseType = 'json';
    var allowAjaxCall = true;
    var xmlhttp = false;
    if (window.XMLHttpRequest)
    {/* code for IE7+, Firefox, Chrome, Opera, Safari*/
        xmlhttp = new XMLHttpRequest();
    }
    else
    {/* code for IE6, IE5*/
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    var str = document.getElementById(ID).value;
    if(str.trim()==""){
        return;
    }

    if(URL.indexOf("#")==0){
        URL = URL.replace("#","");
        var arrURL = URL.split(",");
        var arrURL1 = new Array();
        var arrlength = arrURL.length;
        
        for(var i=0;i<arrlength;i++){
            
            if(arrURL[i].indexOf(str)>=0)
            {
              arrURL1.push(arrURL[i]);
            }
        }
        arrURL =arrURL1;
        var jsonString = JSON.stringify(arrURL);
        var data = JSON.parse(jsonString);
        IP_autoCompleteProcess(ID,IDDiv, e, data,className);
    }else{
    xmlhttp.open("POST", URL + document.getElementById(ID).value, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var senddata = "";

    xmlhttp.send(senddata);

    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState = 4 && xmlhttp.status == 200 && allowAjaxCall) {

            if (xmlhttp.responseText != "") {
                allowAjaxCall = false;
                switch (responseType) {
                    case 'json':
                        {
                            var data = JSON.parse(xmlhttp.responseText);

                            IP_autoCompleteProcess(ID,IDDiv, e, data,className);

                            break;
                        }
                }

            }
        }

    }
    }
}

/*Iperfect Standard library for autocomplete ends*/

function IP_fillDependentList(thisListID,URL,otherListID,arrPost){
var allowAjaxCall=true;
var optionObj;
var selectObj;
var responseType='json';
var xmlhttp = false;
if (window.XMLHttpRequest)
{/* code for IE7+, Firefox, Chrome, Opera, Safari*/
            xmlhttp = new XMLHttpRequest();
        }
        else
        {/* code for IE6, IE5*/
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.open("POST", URL + document.getElementById(thisListID).value, true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "";
        for (var key in arrPost) {
            data = data + key + "=" + arrPost[key] + "&";
        }
        data = IP_rtrim(data);

        xmlhttp.send(data);

        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState = 4 && xmlhttp.status == 200 && allowAjaxCall) {

                if (xmlhttp.responseText != "") {
                    allowAjaxCall = false;
                    switch (responseType) {
                        case 'html':
                        {
                            break;
                        }
                        case 'json':
                        {
                            selectObj = document.getElementById(otherListID);
                            selectObj.options.length = 0;
                            setTimeout(function (){
                                var resp = JSON.parse(xmlhttp.responseText);
                                for (var n in resp)
                                {
                                    optionObj = document.createElement("option");
                                    optionObj.value = n;
                                    optionObj.text = resp[n];
                                    selectObj.add(optionObj);
                                }
                            },100);
                            try {
                                selectObj.onchange();
                            } catch (err)
                            {
                                if (err.toString().indexOf('.onchange is not a function') == -1){
                                    console.log("IP error : " + otherListID + "->" + err);
                                }
                            }
                            break;
                        }
                    }
                }
            }
        }
    }

function IP_fillList(thisListID,URL,arrPost){
var allowAjaxCall=true;
var optionObj;
var selectObj;
var responseType='json';
var xmlhttp = false;
if (window.XMLHttpRequest)
{/* code for IE7+, Firefox, Chrome, Opera, Safari*/
            xmlhttp = new XMLHttpRequest();
        }
        else
        {/* code for IE6, IE5*/
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.open("POST", URL, true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "";
        for (var key in arrPost) {
            data = data + key + "=" + arrPost[key] + "&";
        }
        data = IP_rtrim(data);

        xmlhttp.send(data);

        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState = 4 && xmlhttp.status == 200 && allowAjaxCall) {

                if (xmlhttp.responseText != "") {
                    allowAjaxCall = false;
                    switch (responseType) {
                        case 'html':
                        {
                            break;
                        }
                        case 'json':
                        {
                            selectObj = document.getElementById(thisListID);
                            selectObj.options.length = 0;
                                setTimeout(function (){
                                    var resp = JSON.parse(xmlhttp.responseText);
                                    for (var n in resp)
                                    {
                                        optionObj = document.createElement("option");
                                        optionObj.value = n;
                                        optionObj.text = resp[n];
                                        selectObj.add(optionObj);
                                    }                                
                                },100);
                            break;
                        }
                    }
                }
            }
        }
    }
function IP_recursiveReplace(str, find, replace){
    return str.replace(new RegExp(find, 'g'), replace);
}
function IP_tagEncode(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}
function IP_queryString (key) {  
  return unescape(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + escape(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));
}  