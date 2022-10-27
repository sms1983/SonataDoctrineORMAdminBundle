<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\DoctrineORMAdminBundle\Tests\Functional;

use Symfony\Component\HttpFoundation\Request;

final class FetchJoinAdminTest extends BaseFunctionalTestCase
{
    public function testCountFetchJoined(): void
    {
        $this->client->request(Request::METHOD_GET, '/admin/tests/app/author/list');

        self::assertSelectorTextContains('tr[data-author-id="author_with_two_books"] .js-number-of-books', '2');
        self::assertSelectorTextContains('tr[data-author-id="author_with_two_books"] .js-number-of-readers', '200');
        self::assertSelectorExists('tr[data-author-id="author_with_two_books"]');
        self::assertSelectorExists('tr[data-author-id="miguel_de_cervantes"]');
        self::assertSelectorExists('tr[data-author-id="anonymous"]');
    }

    public function testBatchAction(): void
    {
        $this->client->request(Request::METHOD_GET, '/admin/tests/app/book/list');
        $this->client->submitForm('OK', [
            'all_elements' => true,
            'action' => 'delete',
        ]);
        $this->client->submitForm('Yes, execute');

        self::assertResponseIsSuccessful();
    }

    public function testBatchActionFetchJoined(): void
    {
        $this->client->request(Request::METHOD_GET, '/admin/tests/app/author/list');
        $this->client->submitForm('OK', [
            'all_elements' => true,
            'action' => 'delete',
        ]);
        $this->client->submitForm('Yes, execute');

        self::assertResponseIsSuccessful();
    }
}