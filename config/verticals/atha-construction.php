<?php

/**
 * Atha Construction — Vertical Configuration
 *
 * Each vertical has its own config file with this same shape.
 * Add new verticals by creating a new file in config/verticals/.
 */
return [
    'name'     => 'Atha Construction',
    'slug'     => 'atha-construction',
    'color'    => '#f97316', // brand accent — used in UI badges, headers
    'api_base' => env('ATHA_API_BASE_URL', 'http://127.0.0.1:8000/api/v1'),
    'token'    => env('ATHA_API_TOKEN', ''),

    // Modules enabled for this vertical
    'modules'  => ['leads'],

    // Lead form field config — controls what fields appear on the create/edit form
    'lead_fields' => [
        ['key' => 'name',     'label' => 'Full Name',     'type' => 'text',     'required' => true],
        ['key' => 'email',    'label' => 'Email Address', 'type' => 'email',    'required' => false],
        ['key' => 'phone',    'label' => 'Phone Number',  'type' => 'text',     'required' => true],
        ['key' => 'type',     'label' => 'Project Type',  'type' => 'select',   'required' => false,
         'options' => ['residential', 'commercial', 'industrial', 'renovation']],
        ['key' => 'plotsize', 'label' => 'Plot Size',     'type' => 'text',     'required' => false],
        ['key' => 'message',  'label' => 'Message',       'type' => 'textarea', 'required' => false],
        ['key' => 'source',   'label' => 'Lead Source',   'type' => 'text',     'required' => false],
    ],

    // Lead status options — used for filtering and the status badge
    'lead_statuses' => [
        'pending'   => ['label' => 'Pending',   'color' => 'yellow'],
        'contacted' => ['label' => 'Contacted', 'color' => 'blue'],
        'converted' => ['label' => 'Converted', 'color' => 'green'],
        'rejected'  => ['label' => 'Rejected',  'color' => 'red'],
    ],
];
