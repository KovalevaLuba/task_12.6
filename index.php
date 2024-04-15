<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

function getFullnameFromParts ($surname, $name, $patronomyc) {
    return $fullName = $surname . ' ' . $name . ' ' . $patronomyc;
};

function getPartsFromFullname ($fullName) {
    $keys = ['surname', 'name', 'patronomyc'];
	$values = explode(" ", $fullName);
	return (array_combine($keys, $values));
};

function getShortName ($fullName) {
    $array = getPartsFromFullname($fullName);
    return ($array['surname'] . ' ' . mb_substr($array['name'], 0, 1) . '.');
}

function getGenderFromName ($fullName) {
    $array = getPartsFromFullname($fullName);
    $genderMark = 0;

    if (str_ends_with($array['surname'], 'в')) {
        $genderMark++;
    } elseif (str_ends_with($array['surname'], 'ва')) {
        $genderMark--;
    } 
    if (str_ends_with($array['name'], 'й') or str_ends_with($array['name'], 'н')) {
        $genderMark++;
    } elseif (str_ends_with($array['name'], 'а')) {
        $genderMark--;
    }
    if (str_ends_with($array['patronomyc'], 'ич')) {
        $genderMark++;
    } elseif (str_ends_with($array['patronomyc'], 'вна')) {
        $genderMark--;
    }

        return $genderMark <=> 0;
}


function getGenderDescription ($array) {
    $menArray = array_filter($array, function ($person) {
        return (getGenderFromName ($person['fullname']) == 1);
    });
    $womenArray = array_filter($array, function($person) {
        return (getGenderFromName($person['fullname']) == -1);
    });
    $unknownArray = array_filter($array, function($person) {
        return (getGenderFromName($person['fullname']) == 0);
});

    $countMen = round(count($menArray)/count($array)*100, 1);
    $countWomen = round(count($womenArray)/count($array)*100, 1);
    $countUnknown = round(count($unknownArray)/count($array)*100, 1);
    $genderDescription = 
    "Гендерный состав аудитории:\n
    ---------------------------\n
    Мужчины - $countMen% \n
    Женщины - $countWomen%\n
    Не удалось определить - $countUnknown%";
  return $genderDescription;  
}

function getPerfectPartner ($surname, $name, $patronomyc, $array) {
    $currentSurname = strtoupper(substr($surname, 0, 1)) . strtolower(substr($surname,1));
    $currentName = strtoupper(substr($name, 0, 1)) . strtolower(substr($name,1));
    $currentPatronomyc = strtoupper(substr($patronomyc, 0, 1)) . strtolower(substr($patronomyc,1));

    $currentFullName = getFullnameFromParts ($currentSurname, $currentName, $currentPatronomyc);
    $currentShortName = getShortName ($currentFullName);
    $currentGenderMark = getGenderFromName ($currentFullName);

    if ($currentGenderMark == 0) {
        echo 'Не удалось найти пару';
    } else {
       do {
        $partnerIndex = rand(0, count($array)-1);
        $partnerFullname = $array[$partnerIndex]['fullname'];
        $partnerShortName = getShortName ($partnerFullname);
        $partnerGender = getGenderFromName ($partnerFullname);
       } while ($partnerGender == $currentGenderMark || $partnerGender == 0);
    
    $percentage = round(rand(50, 100), 2);

$partnerResult = 
<<<MYHEREDOCTEXT
$currentShortName + $partnerShortName = 
♡ Идеально на $percentage% ♡
MYHEREDOCTEXT;

return $partnerResult;
    }
}

echo (getPerfectPartner ('Иванов', 'ИВАН', 'иванович', $example_persons_array))
?>