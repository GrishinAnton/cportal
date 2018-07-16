<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Языковые ресурсы для проверки значений
    |--------------------------------------------------------------------------
    |
    | Последующие языковые строки содержат сообщения по-умолчанию, используемые
    | классом, проверяющим значения (валидатором).Некоторые из правил имеют
    | несколько версий, например, size. Вы можете поменять их на любые
    | другие, которые лучше подходят для вашего приложения.
    |
    */
    'accepted'             => 'Вы должны принять :attribute.',
    'active_url'           => 'Недействительный URL.',
    'after'                => 'В поле :attribute должна быть дата после :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'Только буквы.',
    'alpha_dash'           => 'Только буквы, цифры и дефис.',
    'alpha_num'            => 'Только буквы и цифры.',
    'array'                => 'Поле :attribute должно быть массивом.',
    'before'               => 'Введите дату до :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'Значение должно быть от :min до :max.',
        'file'    => 'Размер файла должен быть от :min до :max Кб.',
        'string'  => 'Количество символов от :min до :max.',
        'array'   => 'Количество элементов в поле :attribute должно быть между :min и :max.',
    ],
    'boolean'              => 'Поле :attribute должно иметь значение логического типа.',
    'confirmed'            => 'Поле :attribute не совпадает с подтверждением.',
    'date'                 => 'Поле не является датой.',
    'date_format'          => 'Неверный формат даты',
    'different'            => 'Поля :attribute и :other должны различаться.',
    'digits'               => 'Длина должна быть :digits.',
    'digits_between'       => 'Длина должна быть от :min до :max.',
    'dimensions'           => 'Недопустимые размеры изображения.',
    'distinct'             => 'Поле содержит повторяющееся значение.',
    'email'                => 'Неверный формат email',
    'file'                 => 'Поле должно быть файлом.',
    'filled'               => 'Поле обязательно для заполнения.',
    'exists'               => 'Запись не найдена.',
    'image'                => 'Поле должно быть изображением.',
    'in'                   => 'Выбранное значение не корректно.',
    'in_array'             => 'Поле :attribute не существует в :other.',
    'integer'              => 'Поле должно быть целым числом.',
    'ip'                   => 'Поле должно быть действительным IP-адресом.',
    'json'                 => 'Поле должно быть JSON строкой.',
    'max'                  => [
        'numeric' => 'Максимальное значение :max.',
        'file'    => 'Максимальный размер файла :max Кб.',
        'string'  => 'Максимальное количество символов :max.',
        'array'   => 'Максимальное количество элементов :max.',
    ],
    'mimes'                => 'Поле должно быть файлом одного из следующих типов: :values.',
    'mimetypes'            => 'Поле должно быть файлом одного из следующих типов: :values.',
    'min'                  => [
        'numeric' => 'Минимальное значение :min.',
        'file'    => 'Минимальный размер файла :min Кб.',
        'string'  => 'Минимальное количество символов :min.',
        'array'   => 'Минимальное количество элементов :min.',
    ],
    'not_in'               => 'Выбранное значение ошибочно.',
    'numeric'              => 'Поле должно быть числом.',
    'phone'                => 'Некорректный номер',
    'present'              => 'Поле :attribute должно присутствовать.',
    'regex'                => 'Поле имеет ошибочный формат.',
    'required'             => 'Поле обязательно для заполнения.',
    'required_if'          => 'Поле обязательно для заполнения, когда :other равно :value.',
    'required_unless'      => 'Поле обязательно для заполнения, когда :other не равно :values.',
    'required_with'        => 'Поле обязательно для заполнения, когда :values указано.',
    'required_with_all'    => 'Поле обязательно для заполнения, когда :values указано.',
    'required_without'     => 'Поле обязательно для заполнения, когда :values не указано.',
    'required_without_all' => 'Поле обязательно для заполнения, когда ни одно из :values не указано.',
    'same'                 => 'Значение должно совпадать с :other.',
    'size'                 => [
        'numeric' => 'Введите число :size.',
        'file'    => 'Размер файла должен быть равен :size Кб.',
        'string'  => 'Количество символов должно быть равным :size.',
        'array'   => 'Количество элементов должно быть равным :size.',
    ],
    'string'               => 'Введите строку.',
    'timezone'             => 'Неправильный часовой пояс.',
    'unique'               => 'Такое значение уже существует.',
    'uploaded'             => 'Загрузка не удалась.',
    'url'                  => 'Поле имеет ошибочный формат.',
    /*
    |--------------------------------------------------------------------------
    | Собственные языковые ресурсы для проверки значений
    |--------------------------------------------------------------------------
    |
    | Здесь Вы можете указать собственные сообщения для атрибутов.
    | Это позволяет легко указать свое сообщение для заданного правила атрибута.
    |
    | http://laravel.com/docs/5.1/validation#custom-error-messages
    | Пример использования
    |
    |   'custom' => [
    |       'email' => [
    |           'required' => 'Нам необходимо знать Ваш электронный адрес!',
    |       ],
    |   ],
    |
    */
    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Собственные названия атрибутов
    |--------------------------------------------------------------------------
    |
    | Последующие строки используются для подмены программных имен элементов
    | пользовательского интерфейса на удобочитаемые. Например, вместо имени
    | поля "email" в сообщениях будет выводиться "электронный адрес".
    |
    | Пример использования
    |
    |   'attributes' => [
    |       'email' => 'электронный адрес',
    |   ],
    |
    */
    'attributes'           => [
        //
    ],
];
