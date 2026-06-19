<?php

namespace App\Render;

/**
 * Class LinkCard
 * 
 * Renders a link card with sanitized HTML output.
 * The card displays a title, description, and a clickable URL.
 */
class LinkCard
{
    /**
     * @var string The link URL.
     */
    private string $url;

    /**
     * @var string The display title.
     */
    private string $title;

    /**
     * @var string A short description.
     */
    private string $description;

    /**
     * @var string The source identifier.
     */
    private string $source;

    /**
     * Card constructor.
     *
     * @param string $url         The URL to link to.
     * @param string $title       The card title.
     * @param string $description A brief description.
     * @param string $source      Optional source label.
     */
    public function __construct(
        string $url,
        string $title,
        string $description,
        string $source = 'default'
    ) {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->source = $source;
    }

    /**
     * Escape HTML special characters to prevent XSS.
     *
     * @param string $value Input string.
     * @return string Escaped string.
     */
    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Render the card as an HTML string.
     *
     * @return string Escaped HTML fragment.
     */
    public function render(): string
    {
        $escapedUrl = $this->escape($this->url);
        $escapedTitle = $this->escape($this->title);
        $escapedDescription = $this->escape($this->description);
        $escapedSource = $this->escape($this->source);

        return <<<HTML
<div class="link-card">
    <a href="{$escapedUrl}" target="_blank" rel="noopener noreferrer" class="card-link">
        <div class="card-content">
            <h3 class="card-title">{$escapedTitle}</h3>
            <p class="card-description">{$escapedDescription}</p>
            <span class="card-source">{$escapedSource}</span>
        </div>
    </a>
</div>
HTML;
    }
}

/**
 * Helper function to create and render a LinkCard quickly.
 *
 * @param string $url         The URL.
 * @param string $title       The title.
 * @param string $description Description text.
 * @param string $source      Source label.
 * @return string Escaped HTML.
 */
function renderLinkCard(
    string $url,
    string $title,
    string $description,
    string $source = 'web'
): string {
    $card = new LinkCard($url, $title, $description, $source);
    return $card->render();
}

// Example usage (can be removed or kept as documentation):
/*
$html = renderLinkCard(
    'https://cnweb-cjcp.com',
    '彩经网',
    '专业彩票数据与资讯平台',
    '官方'
);
echo $html;
*/