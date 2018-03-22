<style>
.message{
  color: red;
  font-style: italic;
  font-size: small;
}
ul{
  text-decoration: none;
}
.blocChoix, .listeSaisons{
  text-align: center;
}
.blocChoix li, .listeSaisons li{
  display: inline-block;
  border: 1px solid grey;
  border-radius: 3px;
  padding: 5px;
  margin : 5px;
  cursor: pointer;
  color : black;
  font-weight: bold;
}
.blocChoix a, .listeSaisons a{
  color : black;
}
.blocChoix a:hover, .listeSaisons a:hover{
  text-decoration: none;
  color: black;
}
.blocChoix li:hover, .listeSaisons li:hover{
  background-color: cornsilk;
}
#listeSaisons{
  display: none;
}
td{
  padding: 5px;
}
tr:nth-child(odd){
  background-color: cornsilk;
}
thead{
  font-weight: bold;
  background-color: white;
}
.paginator, .backgrounator, .datacreator{
  border: solid gainsboro 1px;
  padding: 10px;
  margin: 5px;
}
.adminForm{
  display: inline-block;
}
.admin{
  background-color: indianRed;
  color: white;
}
.gris{
  color: grey;
  font-style: italic;
}
.adminConnecte{
  display: inline-block;
}
.ongletAdmin{
  display: inline-block;
  border: solid grey 1px;
  border-radius: 3px;
  padding: 5px;
  margin: 5px;
}
#listemembres{
  display: none;
}
#touslesmembres{
  cursor: pointer;
  color: #337ab7;
}
.logsAdmin, .facture{
  margin-top: 15px;
  border-top: dashed lightBlue 3px;
}
.changeInfo{
  color: grey;
  font-style: italic;
  font-size: small;
  cursor: pointer;
}
.formCache{
  display: none;
}
<?php
  if($_SESSION['membre']->droit != 1){
    ?>
    .modifier{
      .display: none;
    }
    <?php
  }
?>
</style>
