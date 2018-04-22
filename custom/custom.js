$(document).ready(function(){
  //console.log("jquery works");

  //function myClickHandler(){
  //so direkt als delegate/callback an click-handler uebergebbar
  myClickHandler = function(longPoll = false){
    if($("#output").text() == "initial state")
      $("#output").text("pls wait data is fetched");

    //optional die inputmsg mit senden, sonst "23"
    let fieldVal = "23";
    if($("#optInput").val() != "")
      fieldVal = $("#optInput").val();

    let postData = null;
    if(longPoll === false)	//(longPoll === undefined) //so geht es ohne standardwert
      postData = {my_val: fieldVal};
    else //do longpolling
      postData = {my_val: fieldVal, lp: "true"};

    console.log(postData)

    $.getJSON("./long_polling.php", postData, function(data, state){
      console.log("status: " + state);

      //output zusammensetzen
      let out = data;
      for(let i in data)
        out += "\nObject structure: " + i + ": " + data[i];
      out += "\nworking named property: " + data.first_param;

      //daten in output schreiben
      $("#output").text(out);

      if((longPoll !== false) && (longPoll > 0)){
        console.log("next poll: " + longPoll);
        myClickHandler(longPoll - 1);
      }
    })
    //.done(function(){ console.log("after success handling"); })
    .fail(function(e){ //output if an error occurs
      console.log("error: " + e);
    })
    //.always(function(){ console.log("completed handling"); })
    ;
  }

  /*
  //long polling wrapper
  //-> geht so nicht da nicht auf den response gewartet wird
  //muss in success/oder done
  lpWrapper = function(cnt = 0){
    if(5 > cnt){
      console.log("round: " + cnt + " (type: " + typeof cnt + ")");
      myClickHandler(true);
      lpWrapper(cnt+1);
    }
  }
  */

  //beim klicken daten abrufen
  //$("#theButton").click(myClickHandler);
  //obiges geht nicht mit parametern -> event wird uebergeben
  $("#theButton").click(function(){
    myClickHandler(); //einmalig abrufen(server skript agiert ohne delay)
  });

  $("#thePollButton").click(function(){
    //lpWrapper(); //geht nicht da nicht auf den response gewartet wird -> ist ja so gewollt
    myClickHandler(1000); //1000 mal abrufen (server skript agiert mit delay)
  });
});
