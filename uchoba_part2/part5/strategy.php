<?php
 abstract class Music{
 	abstract function fullmusic();
 class TextMusic extends Music{
 	function prewmusic(){

 		}
    function fullmusic(){

    }
 class TextResultMusic extends TextMusic{
        function fullmusic(){
 class AudioMusic extends Music{
 	function prewmusic(){

 		}
    function fullmusic(){

    }
 class AudioResultMusic extends AudioMusic{
 			return "�������� ����� ������";
 		}
    function fullmusic(){
         return "������ ����� ������";
    }
 //��������� ������
 $text = new TextResultMusic();
 //����� ������
 $audio = new AudioResultMusic();

 echo $text->ResultTextMusic().$audio->prewmusic();


?>
