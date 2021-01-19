<?php

	if(isset($argv[1])){
		$argCnt = count($argv);
			if($argCnt == 5){
				$xInput = $argv[1];
				$yInput = $argv[2];
				$faceDirection = $argv[3];
				$walkString = $argv[4];
				//var_dump(array($xInput,$yInput,$faceDirection,$walkString));
				$res = getRobotPosition($xInput,$yInput,$faceDirection,$walkString);
				if($res == 'Wrong Param'){
					addArgsProperMsg();
				} else {
					echo $res."\n";
				}
			}
	} else {
		addArgsProperMsg();
	}

	function getRobotPosition($X,$Y,$D,$S) {
		if(!$X && !$Y && !$D && !$S && !is_int($X) && !is_int($Y) && !is_string($D) && !is_string($S)) {
			return 'Wrong Param';
		}
		$D = strtoupper($D);
		$S = strtoupper($S);
		$dArr  = array('N'=>'NORTH','E'=>'EAST' ,'S'=>'SOUTH','W'=>'WEST');
		$dArrCount = count($dArr);
		$dKeys = array_keys($dArr);
		$dVals = array_values($dArr);
		$sArr = str_split($S);
		$sArrCount = count($sArr);
		$d = array_search($D, $dArr);

		$currArr = array($X,$Y,$d,$S);
		$resArr = array();
		$x = $X;
		$y = $Y;
		for($i=0;$i <$sArrCount; $i++){
			$currentKey = array_search($d, $dKeys);
			if (strtoupper($sArr[$i]) == 'R') {	
				$d = (isset($dKeys[$currentKey + 1])) ? $dKeys[$currentKey + 1] : $dKeys[0];
				
			} elseif (strtoupper($sArr[$i]) == 'L') {
				$d = (isset($dKeys[$currentKey - 1])) ? $dKeys[$currentKey - 1] : $dKeys[$dArrCount - 1];
			} elseif (strtoupper($sArr[$i]) == 'W' && is_numeric($sArr[$i+1])) {
				
				if($d == 'W' || $d == 'E') {
					if($d == 'E') {
						$x += $sArr[$i+1];
					} else {
						$x -= $sArr[$i+1];
					}
				} elseif ($d == 'N' || $d == 'S') {
					if($d == 'N') {
						$y += $sArr[$i+1];
					} else {
						$y -= $sArr[$i+1];
					}
				} else {
					return 'Wrong Param';
				}
			} elseif (is_numeric($sArr[$i])) {
				continue;
			} else {
				return 'Wrong Param';
			}
		}
		$resArr = array($x,$y,$dArr[$d]);
		return implode(' ', $resArr);
	}

	function addArgsProperMsg(){
		echo "Please Enter Proper Arguments with PHP file \n";
		echo "i.e \n diggyWalkingRobot.php 5 2 SOUTH RW2LW4R \n";
	}