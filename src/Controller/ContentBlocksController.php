<?php
declare(strict_types=1);

namespace ContentBlocks\Controller;

use App\Controller\AppController;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Psr\Http\Message\UploadedFileInterface;

/**
 * ContentBlocks Controller
 *
 * @property \ContentBlocks\Model\Table\ContentBlocksTable $ContentBlocks
 * @method \ContentBlocks\Model\Entity\ContentBlock[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContentBlocksController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $allBlocks = $this->ContentBlocks->find()->toArray();

        // To make it easier to loop over each group of content blocks in the view,
        // transform the list into an array of arrays, where each array is keyed by
        // the group name and contains an array of all content blocks in that group.
        $contentBlocksGrouped = array_reduce($allBlocks, function($grouped, $item) {
            $parent = $item['parent'];
            $groupItems = $grouped[$parent] ?? [];
            $groupItems[] = $item;
            $grouped[$parent] = $groupItems;

            return $grouped;
        }, []);

        $this->set(compact('contentBlocksGrouped'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Content Block id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $id = null) {
        $contentBlock = $this->ContentBlocks->get($id, contain:[]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($contentBlock->type === 'image') {

                $file = $this->request->getUploadedFile('value');
                $uploadedPath = $this->uploadFile($file, $contentBlock->slug);

                if (!$uploadedPath) {
                    $this->Flash->error('Your image could not be uploaded. Please try again, or select a different image.');
                    return $this->redirect(['action' => 'edit', $id]);
                }

                $contentBlock->value = $uploadedPath;

            } else if ($contentBlock->type === 'text') {

                $contentBlock->value = htmlentities($this->request->getData('value'));

            } else if ($contentBlock->type === 'html') {

                // Sanitize the input to make it safe from XSS vulnerabilities.
                $html = \HTMLPurifier::getInstance()->purify($this->request->getData('value'));
                $contentBlock->value = $html;

            }

            // Update previous_value when value field has been updated
            if ($contentBlock->isDirty('value'))
                $contentBlock->previous_value = $contentBlock->getOriginal('value');

            if ($this->ContentBlocks->save($contentBlock)) {
                $this->Flash->success(__('The content block has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The content block could not be saved. Please, try again.'));
        }
        $this->set(compact('contentBlock'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Content Block id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function upload() {
        $file = $this->request->getUploadedFile('upload');
        $uploadedPath = $this->uploadFile($file, 'editor');

        if (!$uploadedPath) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'error' => [
                        'message' => 'Your image could not be uploaded. Please try again, or select a different image.',
                    ]
                ]));
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'url' => $uploadedPath,
            ]));
    }

    private function uploadFile(UploadedFileInterface $file, string $filenamePrefix = null) {
        if ($file->getError() !== 0) {

            if ($file->getError() == 1) {
                $this->Flash->error(__('The file you uploaded is too big'));

            }

            return false;
        }

        $prefix = $filenamePrefix ? $filenamePrefix . '.' : '';

        // Don't use the filename from the end user. It could include unsafe characters such as '../../../../etc/passwd'.
        // But we still want the extension from the client - so lets make that super safe by excluding everything except
        // alphanumeric characters.
        $extension = preg_replace(
            "/[^a-z0-9]/",
            '',
            strtolower((new \SplFileInfo($file->getClientFilename()))->getExtension())
        );

        $newFilename =  $prefix . md5(random_bytes(10)) . '.' . $extension;

        $destDir = new \SplFileInfo(WWW_ROOT . 'content-blocks' . DIRECTORY_SEPARATOR . 'uploads');
        if (!$destDir->isDir()) {
            mkdir($destDir->getPathname(), 0777, true);
        }

        $file->moveTo($destDir->getPathname() . DIRECTORY_SEPARATOR . $newFilename);

        return '/content-blocks/uploads/' . $newFilename;
    }

    /**
     * Restore method
     *
     * @param string|null $id Content Block id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function restore($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $contentBlock = $this->ContentBlocks->get($id);

        // Restore previous_value to value, then clear the previous_value field
        $contentBlock->value = $contentBlock->previous_value;
        $contentBlock->previous_value = null;

        if ($this->ContentBlocks->save($contentBlock)) {
            $this->Flash->success(__('The content block has been restored.'));
        } else {
            $this->Flash->error(__('The content block could not be restored. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
