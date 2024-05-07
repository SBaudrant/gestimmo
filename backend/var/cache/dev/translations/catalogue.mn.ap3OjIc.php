<?php

use Symfony\Component\Translation\MessageCatalogue;

$catalogue = new MessageCatalogue('mn', array (
  'validators' => 
  array (
    'This value should be false.' => 'Энэ утга буруу байх ёстой.',
    'This value should be true.' => 'Энэ утга үнэн байх ёстой.',
    'This value should be of type {{ type }}.' => 'Энэ утга  {{ type }} -н төрөл байх ёстой.',
    'This value should be blank.' => 'Энэ утга хоосон байх ёстой.',
    'The value you selected is not a valid choice.' => 'Сонгосон утга буруу байна.',
    'You must select at least {{ limit }} choice.|You must select at least {{ limit }} choices.' => 'Хамгийн багадаа {{ limit }} утга сонгогдсон байх ёстой.',
    'You must select at most {{ limit }} choice.|You must select at most {{ limit }} choices.' => 'Хамгийн ихдээ {{ limit }} утга сонгогдох боломжтой.',
    'One or more of the given values is invalid.' => 'Өгөгдсөн нэг эсвэл нэгээс олон утга буруу байна.',
    'This field was not expected.' => 'Энэ талбар нь хүлээгдэж байсан юм.',
    'This field is missing.' => 'Энэ талбар нь алга болсон байна.',
    'This value is not a valid date.' => 'Энэ утга буруу date төрөл байна .',
    'This value is not a valid datetime.' => 'Энэ утга буруу цаг төрөл байна.',
    'This value is not a valid email address.' => 'И-майл хаяг буруу байна.',
    'The file could not be found.' => 'Файл олдсонгүй.',
    'The file is not readable.' => 'Файл уншигдахуйц биш байна.',
    'The file is too large ({{ size }} {{ suffix }}). Allowed maximum size is {{ limit }} {{ suffix }}.' => 'Файл хэтэрхий том байна ({{ size }} {{ suffix }}). Зөвшөөрөгдөх дээд хэмжээ  {{ limit }} {{ suffix }} байна.',
    'The mime type of the file is invalid ({{ type }}). Allowed mime types are {{ types }}.' => 'Файлын MIME-төрөл нь буруу байна ({{ type }}). Зөвшөөрөгдөх MIME-төрлүүд {{ types }}.',
    'This value should be {{ limit }} or less.' => 'Энэ утга  {{ limit }} юмуу эсвэл бага байна.',
    'This value is too long. It should have {{ limit }} character or less.|This value is too long. It should have {{ limit }} characters or less.' => 'Энэ утга хэтэрхий урт байна. {{ limit }} тэмдэгтийн урттай юмуу эсвэл бага байна.',
    'This value should be {{ limit }} or more.' => 'Энэ утга {{ limit }} юмуу эсвэл их байна.',
    'This value is too short. It should have {{ limit }} character or more.|This value is too short. It should have {{ limit }} characters or more.' => 'Энэ утга хэтэрхий богино байна. {{ limit }} тэмдэгт эсвэл их байна.',
    'This value should not be blank.' => 'Энэ утга хоосон байж болохгүй.',
    'This value should not be null.' => 'Энэ утга null байж болохгүй.',
    'This value should be null.' => 'Энэ утга null байна.',
    'This value is not valid.' => 'Энэ утга буруу байна.',
    'This value is not a valid time.' => 'Энэ утга буруу цаг төрөл байна.',
    'This value is not a valid URL.' => 'Энэ утга буруу URL байна .',
    'The two values should be equal.' => 'Хоёр утгууд ижил байх ёстой.',
    'The file is too large. Allowed maximum size is {{ limit }} {{ suffix }}.' => 'Файл хэтэрхий том байна. Зөвшөөрөгдөх дээд хэмжээ нь {{ limit }} {{ suffix }} байна.',
    'The file is too large.' => 'Файл хэтэрхий том байна.',
    'The file could not be uploaded.' => 'Файл upload хийгдсэнгүй.',
    'This value should be a valid number.' => 'Энэ утга зөвхөн тоо байна.',
    'This file is not a valid image.' => 'Файл зураг биш байна.',
    'This is not a valid IP address.' => 'IP хаяг зөв биш байна.',
    'This value is not a valid language.' => 'Энэ утга үнэн зөв хэл биш байна.',
    'This value is not a valid locale.' => 'Энэ утга үнэн зөв байршил биш байна.',
    'This value is not a valid country.' => 'Энэ утга үнэн бодит улс биш байна.',
    'This value is already used.' => 'Энэ утга аль хэдийнээ хэрэглэгдсэн байна.',
    'The size of the image could not be detected.' => 'Зургийн хэмжээ тогтоогдож чадсангүй.',
    'The image width is too big ({{ width }}px). Allowed maximum width is {{ max_width }}px.' => 'Зургийн өргөн хэтэрхий том байна ({{ width }}px). Өргөн нь хамгийн ихдээ {{ max_width }}px байх боломжтой.',
    'The image width is too small ({{ width }}px). Minimum width expected is {{ min_width }}px.' => 'Зургийн өргөн хэтэрхий жижиг байна ({{ width }}px). Өргөн нь хамгийн багадаа {{ min_width }}px байх боломжтой.',
    'The image height is too big ({{ height }}px). Allowed maximum height is {{ max_height }}px.' => 'Зургийн өндөр хэтэрхий том байна ({{ height }}px). Өндөр нь хамгийн ихдээ {{ max_height }}px байх боломжтой.',
    'The image height is too small ({{ height }}px). Minimum height expected is {{ min_height }}px.' => 'Зургийн өндөр хэтэрхий жижиг байна ({{ height }}px). Өндөр нь хамгийн багадаа {{ min_height }}px байх боломжтой.',
    'This value should be the user\'s current password.' => 'Энэ утга хэрэглэгчийн одоогийн нууц үг байх ёстой.',
    'This value should have exactly {{ limit }} character.|This value should have exactly {{ limit }} characters.' => 'Энэ утга яг {{ limit }} тэмдэгт байх ёстой.|Энэ утга яг {{ limit }} тэмдэгт байх ёстой.',
    'The file was only partially uploaded.' => 'Файлын зөвхөн хагас нь upload хийгдсэн.',
    'No file was uploaded.' => 'Ямар ч файл upload хийгдсэнгүй.',
    'No temporary folder was configured in php.ini.' => 'php.ini дээр түр зуурын хавтсыг тохируулаагүй байна, эсвэл тохируулсан хавтас байхгүй байна.',
    'Cannot write temporary file to disk.' => 'Түр зуурын файлыг диск руу бичиж болохгүй байна.',
    'A PHP extension caused the upload to fail.' => 'PHP extension нь upload -г амжилтгүй болгоод байна.',
    'This collection should contain {{ limit }} element or more.|This collection should contain {{ limit }} elements or more.' => 'Энэ коллекц {{ limit }} ба түүнээс дээш тооны элемент агуулах ёстой.|Энэ коллекц {{ limit }} ба түүнээс дээш тооны элемент агуулах ёстой.',
    'This collection should contain {{ limit }} element or less.|This collection should contain {{ limit }} elements or less.' => 'Энэ коллекц {{ limit }} ба түүнээс доош тооны элемент агуулах ёстой.|Энэ коллекц {{ limit }} ба түүнээс доош тооны элемент агуулах ёстой.',
    'This collection should contain exactly {{ limit }} element.|This collection should contain exactly {{ limit }} elements.' => 'Энэ коллекц яг {{ limit }} элемент агуулах ёстой.|Энэ коллекц яг {{ limit }} элемент агуулах ёстой.',
    'Invalid card number.' => 'Картын дугаар буруу байна.',
    'Unsupported card type or invalid card number.' => 'Дэмжигдээгүй картын төрөл эсвэл картын дугаар буруу байна.',
    'This is not a valid International Bank Account Number (IBAN).' => 'Энэ утга үнэн зөв Олон Улсын Банкны Дансны Дугаар (IBAN) биш байна.',
    'This value is not a valid ISBN-10.' => 'Энэ утга үнэн зөв ISBN-10 биш байна.',
    'This value is not a valid ISBN-13.' => 'Энэ утга үнэн зөв ISBN-13 биш байна.',
    'This value is neither a valid ISBN-10 nor a valid ISBN-13.' => 'Энэ утга үнэн зөв ISBN-10 юмуу ISBN-13 биш байна.',
    'This value is not a valid ISSN.' => 'Энэ утга үнэн зөв ISSN биш байна.',
    'This value is not a valid currency.' => 'Энэ утга үнэн бодит валют биш байна.',
    'This value should be equal to {{ compared_value }}.' => 'Энэ утга {{ compared_value }} -тaй тэнцүү байх ёстой.',
    'This value should be greater than {{ compared_value }}.' => 'Энэ утга {{ compared_value }} -с их байх ёстой.',
    'This value should be greater than or equal to {{ compared_value }}.' => 'Энэ утга {{ compared_value }} -тай тэнцүү юмуу эсвэл их байх ёстой.',
    'This value should be identical to {{ compared_value_type }} {{ compared_value }}.' => 'Энэ утга {{ compared_value_type }} {{ compared_value }} -тай яг ижил байх ёстой.',
    'This value should be less than {{ compared_value }}.' => 'Энэ утга {{ compared_value }} -с бага байх ёстой.',
    'This value should be less than or equal to {{ compared_value }}.' => 'Энэ утга {{ compared_value }} -тай ижил юмуу эсвэл бага байх ёстой.',
    'This value should not be equal to {{ compared_value }}.' => 'Энэ утга {{ compared_value }} -тай тэнцүү байх ёсгүй.',
    'This value should not be identical to {{ compared_value_type }} {{ compared_value }}.' => 'Энэ утга {{ compared_value_type }} {{ compared_value }} -тай яг ижил байх ёсгүй.',
    'The image ratio is too big ({{ ratio }}). Allowed maximum ratio is {{ max_ratio }}.' => 'Зургийн харьцаа хэтэрхий том байна ({{ ratio }}). Харьцаа нь хамгийн ихдээ {{ max_ratio }} байна.',
    'The image ratio is too small ({{ ratio }}). Minimum ratio expected is {{ min_ratio }}.' => 'Зургийн харьцаа хэтэрхий жижиг байна ({{ ratio }}). Харьцаа нь хамгийн багадаа {{ min_ratio }} байна.',
    'The image is square ({{ width }}x{{ height }}px). Square images are not allowed.' => 'Зураг дөрвөлжин хэлбэртэй байна ({{ width }}x{{ height }}px). Дөрвөлжин зургууд оруулах боломжгүй.',
    'The image is landscape oriented ({{ width }}x{{ height }}px). Landscape oriented images are not allowed.' => 'Зураг хэвтээ байрлалтай байна ({{ width }}x{{ height }}px). Хэвтээ байрлалтай зургууд оруулах боломжгүй.',
    'The image is portrait oriented ({{ width }}x{{ height }}px). Portrait oriented images are not allowed.' => 'Зургууд босоо байрлалтай байна ({{ width }}x{{ height }}px). Босоо байрлалтай зургууд оруулах боломжгүй.',
    'An empty file is not allowed.' => 'Хоосон файл оруулах боломжгүй.',
    'The host could not be resolved.' => 'Хост зөв тохирогдоогүй байна.',
    'This value does not match the expected {{ charset }} charset.' => 'Энэ утга тооцоолсон {{ charset }} тэмдэгттэй таарахгүй байна.',
    'This is not a valid Business Identifier Code (BIC).' => 'Энэ утга үнэн зөв Business Identifier Code (BIC) биш байна.',
    'Error' => 'Алдаа',
    'This is not a valid UUID.' => 'Энэ утга үнэн зөв UUID биш байна.',
    'This value should be a multiple of {{ compared_value }}.' => 'Энэ утга {{ compared_value }} -н үржвэр байх ёстой.',
    'This Business Identifier Code (BIC) is not associated with IBAN {{ iban }}.' => 'Энэ Business Identifier Code (BIC) код нь IBAN {{ iban }} -тай холбоогүй байна.',
    'This value should be valid JSON.' => 'Энэ утга JSON байх ёстой.',
    'This collection should contain only unique elements.' => 'Энэ коллекц зөвхөн давтагдахгүй элементүүд агуулах ёстой.',
    'This value should be positive.' => 'Энэ утга эерэг байх ёстой.',
    'This value should be either positive or zero.' => 'Энэ утга тэг эсвэл эерэг байх ёстой.',
    'This value should be negative.' => 'Энэ утга сөрөг байх ёстой.',
    'This value should be either negative or zero.' => 'Энэ утга сөрөг эсвэл тэг байх ёстой.',
    'This value is not a valid timezone.' => 'Энэ утга үнэн зөв цагийн бүс биш байна.',
    'This password has been leaked in a data breach, it must not be used. Please use another password.' => 'Энэ нууц үгийн мэдээлэл алдагдсан байх магадлалтай учраас дахин ашиглагдах ёсгүй. Өөр нууц үг ашиглана уу.',
    'This value should be between {{ min }} and {{ max }}.' => 'Энэ утга {{ min }} -с {{ max }} хооронд байх ёстой.',
    'This value is not a valid hostname.' => 'Энэ утга буруу hostname байна.',
    'The number of elements in this collection should be a multiple of {{ compared_value }}.' => 'Энэхүү цуглуулган дахь элемэнтийн тоо, {{ compared_value }}-н үржвэр байх ёстой.',
    'This value should satisfy at least one of the following constraints:' => 'Энэ утга доорх болзолуудын ядаж нэгийг хангах ёстой:',
    'Each element of this collection should satisfy its own set of constraints.' => 'Энэхүү цуглуулган дахь элемэнтүүд өөр өөрсдийн болзолуудаа хангах ёстой.',
    'This value is not a valid International Securities Identification Number (ISIN).' => 'Энэ утга зөв International Securities Identification Number (ISIN) биш байна.',
  ),
  'security' => 
  array (
    'An authentication exception occurred.' => 'Нэвтрэх хүсэлтийн алдаа гарав.',
    'Authentication credentials could not be found.' => 'Нэвтрэх эрхийн мэдээлэл олдсонгүй.',
    'Authentication request could not be processed due to a system problem.' => 'Системийн алдаанаас болон нэвтрэх хүсэлтийг гүйцэтгэх боломжгүй байна.',
    'Invalid credentials.' => 'Буруу нэвтрэх эрхийн мэдээлэл.',
    'Cookie has already been used by someone else.' => 'Күүки файлыг аль хэдийн өөр хүн хэрэглэж байна.',
    'Not privileged to request the resource.' => 'Энэхүү мэдээллийг авах эрх хүрэхгүй байна.',
    'Invalid CSRF token.' => 'Тохиромжгүй CSRF токен.',
    'No authentication provider found to support the authentication token.' => 'Нэвтрэх токенг дэмжих нэвтрэх эрхийн хангагч олдсонгүй.',
    'No  available, it either timed out or cookies are not enabled.' => 'Хэрэглэгчийн session олдсонгүй, хугацаа нь дууссан эсвэл күүки идэвхижүүлээгүй байна.',
    'No token could be found.' => 'Токен олдсонгүй.',
    'Username could not be found.' => 'Нэвтрэх нэр олсонгүй.',
    'Account has expired.' => 'Бүртгэлийн хугацаа дууссан байна.',
    'Credentials have expired.' => 'Нэвтрэх эрхийн хугацаа дууссан байна.',
    'Account is disabled.' => 'Бүртгэлийг хаасан байна.',
    'Account is locked.' => 'Бүртгэлийг цоожилсон байна.',
    'Too many failed login attempts, please try again later.' => 'Хэтэрхий олон амжилтгүй оролдлого, түр хүлээгээд дахин оролдоно уу.',
    'Invalid or expired login link.' => 'Буруу эсвэл хугацаа нь дууссан нэвтрэх зам.',
  ),
));

$catalogueFr = new MessageCatalogue('fr', array (
  'validators' => 
  array (
    'This value should be false.' => 'Cette valeur doit être fausse.',
    'This value should be true.' => 'Cette valeur doit être vraie.',
    'This value should be of type {{ type }}.' => 'Cette valeur doit être de type {{ type }}.',
    'This value should be blank.' => 'Cette valeur doit être vide.',
    'The value you selected is not a valid choice.' => 'Cette valeur doit être l\'un des choix proposés.',
    'You must select at least {{ limit }} choice.|You must select at least {{ limit }} choices.' => 'Vous devez sélectionner au moins {{ limit }} choix.|Vous devez sélectionner au moins {{ limit }} choix.',
    'You must select at most {{ limit }} choice.|You must select at most {{ limit }} choices.' => 'Vous devez sélectionner au maximum {{ limit }} choix.|Vous devez sélectionner au maximum {{ limit }} choix.',
    'One or more of the given values is invalid.' => 'Une ou plusieurs des valeurs soumises sont invalides.',
    'This field was not expected.' => 'Ce champ n\'a pas été prévu.',
    'This field is missing.' => 'Ce champ est manquant.',
    'This value is not a valid date.' => 'Cette valeur n\'est pas une date valide.',
    'This value is not a valid datetime.' => 'Cette valeur n\'est pas une date valide.',
    'This value is not a valid email address.' => 'Cette valeur n\'est pas une adresse email valide.',
    'The file could not be found.' => 'Le fichier n\'a pas été trouvé.',
    'The file is not readable.' => 'Le fichier n\'est pas lisible.',
    'The file is too large ({{ size }} {{ suffix }}). Allowed maximum size is {{ limit }} {{ suffix }}.' => 'Le fichier est trop volumineux ({{ size }} {{ suffix }}). Sa taille ne doit pas dépasser {{ limit }} {{ suffix }}.',
    'The mime type of the file is invalid ({{ type }}). Allowed mime types are {{ types }}.' => 'Le type du fichier est invalide ({{ type }}). Les types autorisés sont {{ types }}.',
    'This value should be {{ limit }} or less.' => 'Cette valeur doit être inférieure ou égale à {{ limit }}.',
    'This value is too long. It should have {{ limit }} character or less.|This value is too long. It should have {{ limit }} characters or less.' => 'Cette chaîne est trop longue. Elle doit avoir au maximum {{ limit }} caractère.|Cette chaîne est trop longue. Elle doit avoir au maximum {{ limit }} caractères.',
    'This value should be {{ limit }} or more.' => 'Cette valeur doit être supérieure ou égale à {{ limit }}.',
    'This value is too short. It should have {{ limit }} character or more.|This value is too short. It should have {{ limit }} characters or more.' => 'Cette chaîne est trop courte. Elle doit avoir au minimum {{ limit }} caractère.|Cette chaîne est trop courte. Elle doit avoir au minimum {{ limit }} caractères.',
    'This value should not be blank.' => 'Cette valeur ne doit pas être vide.',
    'This value should not be null.' => 'Cette valeur ne doit pas être nulle.',
    'This value should be null.' => 'Cette valeur doit être nulle.',
    'This value is not valid.' => 'Cette valeur n\'est pas valide.',
    'This value is not a valid time.' => 'Cette valeur n\'est pas une heure valide.',
    'This value is not a valid URL.' => 'Cette valeur n\'est pas une URL valide.',
    'The two values should be equal.' => 'Les deux valeurs doivent être identiques.',
    'The file is too large. Allowed maximum size is {{ limit }} {{ suffix }}.' => 'Le fichier est trop volumineux. Sa taille ne doit pas dépasser {{ limit }} {{ suffix }}.',
    'The file is too large.' => 'Le fichier est trop volumineux.',
    'The file could not be uploaded.' => 'Le téléchargement de ce fichier est impossible.',
    'This value should be a valid number.' => 'Cette valeur doit être un nombre.',
    'This file is not a valid image.' => 'Ce fichier n\'est pas une image valide.',
    'This is not a valid IP address.' => 'Cette adresse IP n\'est pas valide.',
    'This value is not a valid language.' => 'Cette langue n\'est pas valide.',
    'This value is not a valid locale.' => 'Ce paramètre régional n\'est pas valide.',
    'This value is not a valid country.' => 'Ce pays n\'est pas valide.',
    'This value is already used.' => 'Cette valeur est déjà utilisée.',
    'The size of the image could not be detected.' => 'La taille de l\'image n\'a pas pu être détectée.',
    'The image width is too big ({{ width }}px). Allowed maximum width is {{ max_width }}px.' => 'La largeur de l\'image est trop grande ({{ width }}px). La largeur maximale autorisée est de {{ max_width }}px.',
    'The image width is too small ({{ width }}px). Minimum width expected is {{ min_width }}px.' => 'La largeur de l\'image est trop petite ({{ width }}px). La largeur minimale attendue est de {{ min_width }}px.',
    'The image height is too big ({{ height }}px). Allowed maximum height is {{ max_height }}px.' => 'La hauteur de l\'image est trop grande ({{ height }}px). La hauteur maximale autorisée est de {{ max_height }}px.',
    'The image height is too small ({{ height }}px). Minimum height expected is {{ min_height }}px.' => 'La hauteur de l\'image est trop petite ({{ height }}px). La hauteur minimale attendue est de {{ min_height }}px.',
    'This value should be the user\'s current password.' => 'Cette valeur doit être le mot de passe actuel de l\'utilisateur.',
    'This value should have exactly {{ limit }} character.|This value should have exactly {{ limit }} characters.' => 'Cette chaîne doit avoir exactement {{ limit }} caractère.|Cette chaîne doit avoir exactement {{ limit }} caractères.',
    'The file was only partially uploaded.' => 'Le fichier a été partiellement transféré.',
    'No file was uploaded.' => 'Aucun fichier n\'a été transféré.',
    'No temporary folder was configured in php.ini.' => 'Aucun répertoire temporaire n\'a été configuré dans le php.ini.',
    'Cannot write temporary file to disk.' => 'Impossible d\'écrire le fichier temporaire sur le disque.',
    'A PHP extension caused the upload to fail.' => 'Une extension PHP a empêché le transfert du fichier.',
    'This collection should contain {{ limit }} element or more.|This collection should contain {{ limit }} elements or more.' => 'Cette collection doit contenir {{ limit }} élément ou plus.|Cette collection doit contenir {{ limit }} éléments ou plus.',
    'This collection should contain {{ limit }} element or less.|This collection should contain {{ limit }} elements or less.' => 'Cette collection doit contenir {{ limit }} élément ou moins.|Cette collection doit contenir {{ limit }} éléments ou moins.',
    'This collection should contain exactly {{ limit }} element.|This collection should contain exactly {{ limit }} elements.' => 'Cette collection doit contenir exactement {{ limit }} élément.|Cette collection doit contenir exactement {{ limit }} éléments.',
    'Invalid card number.' => 'Numéro de carte invalide.',
    'Unsupported card type or invalid card number.' => 'Type de carte non supporté ou numéro invalide.',
    'This is not a valid International Bank Account Number (IBAN).' => 'Le numéro IBAN (International Bank Account Number) saisi n\'est pas valide.',
    'This value is not a valid ISBN-10.' => 'Cette valeur n\'est pas un code ISBN-10 valide.',
    'This value is not a valid ISBN-13.' => 'Cette valeur n\'est pas un code ISBN-13 valide.',
    'This value is neither a valid ISBN-10 nor a valid ISBN-13.' => 'Cette valeur n\'est ni un code ISBN-10, ni un code ISBN-13 valide.',
    'This value is not a valid ISSN.' => 'Cette valeur n\'est pas un code ISSN valide.',
    'This value is not a valid currency.' => 'Cette valeur n\'est pas une devise valide.',
    'This value should be equal to {{ compared_value }}.' => 'Cette valeur doit être égale à {{ compared_value }}.',
    'This value should be greater than {{ compared_value }}.' => 'Cette valeur doit être supérieure à {{ compared_value }}.',
    'This value should be greater than or equal to {{ compared_value }}.' => 'Cette valeur doit être supérieure ou égale à {{ compared_value }}.',
    'This value should be identical to {{ compared_value_type }} {{ compared_value }}.' => 'Cette valeur doit être identique à {{ compared_value_type }} {{ compared_value }}.',
    'This value should be less than {{ compared_value }}.' => 'Cette valeur doit être inférieure à {{ compared_value }}.',
    'This value should be less than or equal to {{ compared_value }}.' => 'Cette valeur doit être inférieure ou égale à {{ compared_value }}.',
    'This value should not be equal to {{ compared_value }}.' => 'Cette valeur ne doit pas être égale à {{ compared_value }}.',
    'This value should not be identical to {{ compared_value_type }} {{ compared_value }}.' => 'Cette valeur ne doit pas être identique à {{ compared_value_type }} {{ compared_value }}.',
    'The image ratio is too big ({{ ratio }}). Allowed maximum ratio is {{ max_ratio }}.' => 'Le rapport largeur/hauteur de l\'image est trop grand ({{ ratio }}). Le rapport maximal autorisé est {{ max_ratio }}.',
    'The image ratio is too small ({{ ratio }}). Minimum ratio expected is {{ min_ratio }}.' => 'Le rapport largeur/hauteur de l\'image est trop petit ({{ ratio }}). Le rapport minimal attendu est {{ min_ratio }}.',
    'The image is square ({{ width }}x{{ height }}px). Square images are not allowed.' => 'L\'image est carrée ({{ width }}x{{ height }}px). Les images carrées ne sont pas autorisées.',
    'The image is landscape oriented ({{ width }}x{{ height }}px). Landscape oriented images are not allowed.' => 'L\'image est au format paysage ({{ width }}x{{ height }}px). Les images au format paysage ne sont pas autorisées.',
    'The image is portrait oriented ({{ width }}x{{ height }}px). Portrait oriented images are not allowed.' => 'L\'image est au format portrait ({{ width }}x{{ height }}px). Les images au format portrait ne sont pas autorisées.',
    'An empty file is not allowed.' => 'Un fichier vide n\'est pas autorisé.',
    'The host could not be resolved.' => 'Le nom de domaine n\'a pas pu être résolu.',
    'This value does not match the expected {{ charset }} charset.' => 'Cette valeur ne correspond pas au jeu de caractères {{ charset }} attendu.',
    'This is not a valid Business Identifier Code (BIC).' => 'Ce n\'est pas un code universel d\'identification des banques (BIC) valide.',
    'Error' => 'Erreur',
    'This is not a valid UUID.' => 'Ceci n\'est pas un UUID valide.',
    'This value should be a multiple of {{ compared_value }}.' => 'Cette valeur doit être un multiple de {{ compared_value }}.',
    'This Business Identifier Code (BIC) is not associated with IBAN {{ iban }}.' => 'Ce code d\'identification d\'entreprise (BIC) n\'est pas associé à l\'IBAN {{ iban }}.',
    'This value should be valid JSON.' => 'Cette valeur doit être un JSON valide.',
    'This collection should contain only unique elements.' => 'Cette collection ne doit pas comporter de doublons.',
    'This value should be positive.' => 'Cette valeur doit être strictement positive.',
    'This value should be either positive or zero.' => 'Cette valeur doit être supérieure ou égale à zéro.',
    'This value should be negative.' => 'Cette valeur doit être strictement négative.',
    'This value should be either negative or zero.' => 'Cette valeur doit être inférieure ou égale à zéro.',
    'This value is not a valid timezone.' => 'Cette valeur n\'est pas un fuseau horaire valide.',
    'This password has been leaked in a data breach, it must not be used. Please use another password.' => 'Ce mot de passe a été divulgué lors d\'une fuite de données, il ne doit plus être utilisé. Veuillez utiliser un autre mot de passe.',
    'This value should be between {{ min }} and {{ max }}.' => 'Cette valeur doit être comprise entre {{ min }} et {{ max }}.',
    'This value is not a valid hostname.' => 'Cette valeur n\'est pas un nom d\'hôte valide.',
    'The number of elements in this collection should be a multiple of {{ compared_value }}.' => 'Le nombre d\'éléments de cette collection doit être un multiple de {{ compared_value }}.',
    'This value should satisfy at least one of the following constraints:' => 'Cette valeur doit satisfaire à au moins une des contraintes suivantes :',
    'Each element of this collection should satisfy its own set of constraints.' => 'Chaque élément de cette collection doit satisfaire à son propre jeu de contraintes.',
    'This value is not a valid International Securities Identification Number (ISIN).' => 'Cette valeur n\'est pas un code international de sécurité valide (ISIN).',
    'This value should be a valid expression.' => 'Cette valeur doit être une expression valide.',
    'This value is not a valid CSS color.' => 'Cette valeur n\'est pas une couleur CSS valide.',
    'This value is not a valid CIDR notation.' => 'Cette valeur n\'est pas une notation CIDR valide.',
    'The value of the netmask should be between {{ min }} and {{ max }}.' => 'La valeur du masque de réseau doit être comprise entre {{ min }} et {{ max }}.',
    'The filename is too long. It should have {{ filename_max_length }} character or less.|The filename is too long. It should have {{ filename_max_length }} characters or less.' => 'Le nom du fichier est trop long. Il doit contenir au maximum {{ filename_max_length }} caractère.|Le nom de fichier est trop long. Il doit contenir au maximum {{ filename_max_length }} caractères.',
    'The password strength is too low. Please use a stronger password.' => 'La force du mot de passe est trop faible. Veuillez utiliser un mot de passe plus fort.',
    'This value contains characters that are not allowed by the current restriction-level.' => 'Cette valeur contient des caractères qui ne sont pas autorisés par le niveau de restriction actuel.',
    'Using invisible characters is not allowed.' => 'Utiliser des caractères invisibles n\'est pas autorisé.',
    'Mixing numbers from different scripts is not allowed.' => 'Mélanger des chiffres provenant de différents scripts n\'est pas autorisé.',
    'Using hidden overlay characters is not allowed.' => 'Utiliser des caractères de superposition cachés n\'est pas autorisé.',
    'UserUpdatePassword.OldPasswordInvalid' => 'L\'ancien mot de passe n\'est pas valide.',
    'UserUpdatePassword.NewPasswordInvalid' => 'Le mot de passe doit contenir au moins 3 des éléments suivants : minuscules, majuscules, chiffres et caractères spéciaux.',
    'UserInitPassword.ExpiredToken' => 'Le token de réinitialisation a expiré. Veuillez réinitialiser votre mot de passe à nouveau.',
  ),
  'security' => 
  array (
    'An authentication exception occurred.' => 'Une exception d\'authentification s\'est produite.',
    'Authentication credentials could not be found.' => 'Les identifiants d\'authentification n\'ont pas pu être trouvés.',
    'Authentication request could not be processed due to a system problem.' => 'La requête d\'authentification n\'a pas pu être executée à cause d\'un problème système.',
    'Invalid credentials.' => 'Identifiants invalides.',
    'Cookie has already been used by someone else.' => 'Le cookie a déjà été utilisé par quelqu\'un d\'autre.',
    'Not privileged to request the resource.' => 'Privilèges insuffisants pour accéder à la ressource.',
    'Invalid CSRF token.' => 'Jeton CSRF invalide.',
    'No authentication provider found to support the authentication token.' => 'Aucun fournisseur d\'authentification n\'a été trouvé pour supporter le jeton d\'authentification.',
    'No session available, it either timed out or cookies are not enabled.' => 'Aucune session disponible, celle-ci a expiré ou les cookies ne sont pas activés.',
    'No token could be found.' => 'Aucun jeton n\'a pu être trouvé.',
    'Username could not be found.' => 'Le nom d\'utilisateur n\'a pas pu être trouvé.',
    'Account has expired.' => 'Le compte a expiré.',
    'Credentials have expired.' => 'Les identifiants ont expiré.',
    'Account is disabled.' => 'Le compte est désactivé.',
    'Account is locked.' => 'Le compte est bloqué.',
    'Too many failed login attempts, please try again later.' => 'Plusieurs tentatives de connexion ont échoué, veuillez réessayer plus tard.',
    'Invalid or expired login link.' => 'Lien de connexion invalide ou expiré.',
    'Too many failed login attempts, please try again in %minutes% minute.' => 'Plusieurs tentatives de connexion ont échoué, veuillez réessayer dans %minutes% minute.',
    'Too many failed login attempts, please try again in %minutes% minutes.' => 'Plusieurs tentatives de connexion ont échoué, veuillez réessayer dans %minutes% minutes.',
  ),
  'messages+intl-icu' => 
  array (
    'InitPassword.Mail.Subject' => 'Initialisation du mot de passe',
    'InitPassword.Mail.Content.Hello' => 'Bonjour {name}',
    'InitPassword.Mail.Content.ClickLinkToChangePassword' => 'Vous avez récemment fait une demande de modification de votre mot de passe sur l’application. Pour terminer le processus, veuillez cliquer sur le lien ci dessous.',
    'InitPassword.Mail.Content.UpdateNow' => 'Modifier maintenant',
    'InitPassword.Mail.Content.AccountStillSecure' => 'Si vous n’êtes pas l’auteur de cette demande, il est probable qu’un autre utilisateur ait saisi votre identifiant par erreur et qu’en conséquence la sécurité de votre compte soit toujours intacte.',
    'InitPassword.Mail.Content.UpdatePasswordIfCompromised' => 'Si vous pensez qu’une personne a eu accès à votre compte sans votre autorisation, vous devriez changer votre mot de passe dans les plus brefs délais.',
    'InitPassword.Mail.Content.RawLink' => 'Si vous rencontrez des difficultés, vous pouvez recopier le lien suivant',
    'InitPassword.Mail.Content.Regards' => 'Cordialement',
    'NewUser.Mail.Subject' => 'Création de votre compte utilisateur',
    'NewUser.Email.Content.Hello' => 'Bonjour {name}',
    'NewUser.Email.Content.AccountCreated' => 'Votre compte a été créé',
    'NewUser.Email.Content.ClickToFinish' => 'Pour terminer le processus d’activation de votre compte, veuillez cliquer sur le lien ci-dessous',
    'NewUser.Email.Content.ActivateNow' => 'Activer maintenant',
    'NewUser.Email.Content.RawLink' => 'Si vous rencontrez des difficultés, vous pouvez recopier le lien suivant',
    'NewUser.Email.Content.Regards' => 'Cordialement',
  ),
));
$catalogue->addFallbackCatalogue($catalogueFr);

return $catalogue;