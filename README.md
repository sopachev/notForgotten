notForgotten.php - скрипт, проверяющий есть ли у игроков Destiny 2, перечисленных в input.log, в инвентаре предмет "Not Forgotten".

bungieNet.php - класс для взаимодействия с bungie.net API. Для работы необходимо указать корректный api key в $apiKey.
Свойство debug включает вывод отладочной информации.

input.log - файл, содержащий никнеймы пользователей, которых будем проверять.

В процессе работы скрипта будет создан файл output.log с результатами проверки.
Для игроков, данные которых скрыты (Hidden by Privacy Settings), в output.log будет указано "no", как и для игроков, у которых предмета нет.
Чтобы явно отмечать в output.log игроков, данные которых скрыты, необходимо добавить проверку наличия блока Response->profileCollectibles->data в методе checkUserHasItem


