<?php

declare(strict_types=1);

return [
    'placeholder' => 'N/A',
    'navigation' => [
        'title' => 'Log Viewer',
        'heading' => 'Log tabel',
        'subheading' => '',
        'group' => 'Systeem',
        'label' => 'Log Viewer',
    ],
    'table' => [
        'columns' => [
            'log_level' => 'Log niveau',
            'env' => 'Omgeving',
            'file' => 'Bestand',
            'message' => 'Samenvatting',
            'date' => 'Datum',
        ],
        'filters' => [
            'env' => [
                'label' => 'Omgeving',
                'indicator' => 'Gefilterd op omgeving',
            ],
            'file' => [
                'label' => 'Bestand',
                'indicator' => 'Gefilterd op bestand',
            ],
            'date' => [
                'label' => 'Datum',
                'indicator' => 'Gefilterd op datum',
                'from' => 'Van',
                'until' => 'Tot',
            ],
            'date_range' => [
                'label' => 'Datumbereik',
                'indicator' => 'Gefilterd op datumbereik',
            ],
            'indicators' => [
                'logs_from_to' => 'Logs van :from tot :until',
                'logs_from' => 'Logs van :from',
                'logs_until' => 'Logs tot :until',
            ],
        ],
        'actions' => [
            'view' => [
                'label' => 'Bekijk Log',
                'heading' => 'Foutlog',
            ],
            'read' => [
                'label' => 'Lees Mail',
                'subject' => 'Onderwerp',
                'mail_log' => 'Mail Log',
                'sent_date' => 'Verzonden Datum',
            ],
            'refresh' => [
                'label' => 'Vernieuwen',
            ],
            'clear' => [
                'label' => 'Wis Logs',
                'success' => 'Alle logs zijn gewist!',
            ],
        ],
    ],
    'schema' => [
        'error-log' => [
            'stack' => 'Stack Trace',
        ],
        'json-log' => [
            'context' => 'Context',
        ],
    ],
    'mail' => [
        'sender' => [
            'label' => 'Afzender',
            'name' => 'Naam',
            'email' => 'E-mail',
        ],
        'receiver' => [
            'label' => 'Ontvanger',
            'name' => 'Naam',
            'email' => 'E-mail',
        ],
        'content' => 'Inhoud',
        'plain' => 'Platte Tekst',
        'html' => 'HTML',
    ],
    'levels' => [
        'all' => 'Alle Logs',
        'alert' => 'Waarschuwing',
        'critical' => 'Kritiek',
        'debug' => 'Debug',
        'emergency' => 'Noodgeval',
        'error' => 'Fout',
        'info' => 'Info',
        'notice' => 'Opmerking',
        'warning' => 'Waarschuwing',
        'mail' => 'Mail',
    ],
];
