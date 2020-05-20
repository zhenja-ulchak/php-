<?php
 abstract class Music{ 	abstract function prewmusic();
 	abstract function fullmusic(); }
 class TextMusic extends Music{ 	function ResultTextMusic(){ 	return "Вы выбрали текстовую версию песни: Тип:"; 	}
 	function prewmusic(){

 		}
    function fullmusic(){

    } }
 class TextResultMusic extends TextMusic{ 		function prewmusic(){ 			return "Неполная текстовая версия"; 		}
        function fullmusic(){         return "Полная текстовая версия";        } }
 class AudioMusic extends Music{ 	function ResultAudioMusic(){ 		return "Вы выбрали аудио версию песни: Тип:"; 	}
 	function prewmusic(){

 		}
    function fullmusic(){

    } }
 class AudioResultMusic extends AudioMusic{ 	function prewmusic(){
 			return "Неполная аудио версия";
 		}
    function fullmusic(){
         return "Полная аудио версия";
    } }
 //Текстовая версия
 $text = new TextResultMusic();
 //Аудио версия
 $audio = new AudioResultMusic();

 echo $text->ResultTextMusic().$audio->prewmusic();


?>

