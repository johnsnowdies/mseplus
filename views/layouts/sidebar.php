<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu">
            <li class="nav-header">
                <div class="profile-element">
<h2 style="color: #ffffff; margin-top:0!important;">Multiverse Stock <br>Exchange +</h2>
                </div>
                <div class="logo-element">
                    MSE+
                </div>
            </li>

        </ul>

        <?php
            $menu=[

                [
                    'url' => '/',
                    'icon' => 'fa fa-home',
                    'label' => 'Главная'
                ],
                [
                    'url' => '/currencies/',
                    'icon' => 'fa fa-money',
                    'label' => 'Валюты'
                ],
                [
                    'url' => '#',
                    'icon' => 'fa fa-globe',
                    'label' => 'Новости'
                ],
                [
                    'url' => '/markets/',
                    'icon' => 'fa fa-chart-line',
                    'label' => 'Биржи'
                ],

           
                [
                    'url' => '/stock/',
                    'icon' => 'fa fa-exchange',
                    'label' => 'Кампании'
                ],
                
            ];

            if(isset($this->context->menu))
                $menu = array_merge([['label' => \Yii::$app->name, 'options' => ['class' => 'nav-header']]], $this->context->menu);

        ?>
        <?= jcabanillas\inspinia\widgets\Menu::widget(
            [
                'options' => ['class' => 'nav metismenu', 'id'=>'side-menu'],
                'submenuTemplate' => "\n<ul class='nav nav-second-level collapse' {show}>\n{items}\n</ul>\n",
                'items' => $menu,
            ]
        ) ?>
    </div>
</nav>