<?php

namespace App\Service;

class DomainService
{
    public static function getAppDomain(): string
    {
        $host = $_SERVER['HTTP_HOST'];

        // Check if the host is a localhost URL
        if (str_contains($host, 'localhost') || str_contains($host, '127.0.0.1')) {
            // For local development, always return 'localhost'
            return 'localhost';
        } else {
            // For production, split the host and get the required part
            $parts = explode('.', $host);
            if (count($parts) > 3) {
                $domain = $parts[1]; // This will be 'way4' in your example
            } elseif (count($parts) == 3) {
                $domain = $parts[0]; // For URLs like 'subdomain.domain.com'
            } else {
                // If there's no subdomain, return the whole domain
                $domain = $host;
            }
        }

        return $domain;
    }
}
