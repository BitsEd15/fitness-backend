<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        // Логика для получения списка статей
        $articles = Article::get();
        return response()->json($articles);
    }
    public function show(Article $article)
    {
        // Логика для получения конкретной статьи
    return response()->json($article);
    }

    public function store(StoreArticleRequest $request)
    {
        // Логика для создания новой статьи
        $data = $request->validated();

        // Проверяем, был ли отправлен файл
        if ($request->hasFile('image')) 
            {
            // Метод store() сохраняет файл в папку storage/app/public/articles
            // и возвращает путь относительно этой папки (например, "articles/abc123.jpg")
            // 'public' — это диск, который мы используем (настроен в config/filesystems.php)
            // 'articles' — это подпапка, куда будем складывать картинки статей
            $path = $request->file('image')->store('articles', 'public');
            
            // Записываем этот путь в массив данных под ключом image_path
            // (именно так называется колонка в базе данных)
            $data['image_path'] = $path;
            }

        $article = Article::create($data);
        return response()->json($article, 201);
    }
    public function update(UpdateArticleRequest $request, Article $article)
    {
        // Логика для обновления существующей статьи по ID
        $data = $request->validated();
        // Если пришел новый файл — сохраняем его и обновляем путь
         if ($request->hasFile('image')) 
                {
                $path = $request->file('image')->store('articles', 'public');
                $data['image_path'] = $path;
            // Опционально: можно удалить старый файл, чтобы не засорять диск
            // Но для начала можно это не делать
                }
        $article->update($data);
        return response()->json($article);
    }
    public function destroy(Article $article)
    {
        // Логика для удаления статьи по ID
        $article->delete();
        return response()->noContent();
    }
}
