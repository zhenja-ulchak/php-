<?php
 abstract class Music{ 	abstract function prewmusic();
 	abstract function fullmusic(); }
 class TextMusic extends Music{ 	function ResultTextMusic(){ 	return "�� ������� ��������� ������ �����: ���:"; 	}
 	function prewmusic(){

 		}
    function fullmusic(){

    } }
 class TextResultMusic extends TextMusic{ 		function prewmusic(){ 			return "�������� ��������� ������"; 		}
        function fullmusic(){         return "������ ��������� ������";        } }
 class AudioMusic extends Music{ 	function ResultAudioMusic(){ 		return "�� ������� ����� ������ �����: ���:"; 	}
 	function prewmusic(){

 		}
    function fullmusic(){

    } }
 class AudioResultMusic extends AudioMusic{ 	function prewmusic(){
 			return "�������� ����� ������";
 		}
    function fullmusic(){
         return "������ ����� ������";
    } }
 //��������� ������
 $text = new TextResultMusic();
 //����� ������
 $audio = new AudioResultMusic();

 echo $text->ResultTextMusic().$audio->prewmusic();


?>

