<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Filament\Resources\BlogPostResource\RelationManagers;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'المدونة';

    protected static ?string $modelLabel = 'موضوع';

    protected static ?string $pluralModelLabel = 'مواضيع المدونة';

    protected static ?string $navigationGroup = 'الموقع';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('بيانات الموضوع')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('صورة الموضوع')
                            ->image()
                            ->disk('public')
                            ->directory('blog')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1600')
                            ->imageResizeTargetHeight('900')
                            ->maxSize(20480)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('يفضّل صورة أفقية بنسبة 16:9 (حتى 20 ميجابايت).')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('title')
                            ->label('عنوان الموضوع')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state, Forms\Get $get): void {
                                if (filled($get('slug'))) {
                                    return;
                                }

                                $slug = Str::slug($state ?? '');

                                if (blank($slug) && filled($state)) {
                                    $slug = 'post-'.Str::lower(Str::random(6));
                                }

                                $set('slug', $slug);
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->label('الرابط المختصر')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('مثال: how-to-register-property'),
                        Forms\Components\Textarea::make('excerpt')
                            ->label('مقتطف قصير')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('body')
                            ->label('محتوى الموضوع')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('تاريخ النشر')
                            ->seconds(false)
                            ->default(now()),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('ترتيب العرض')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_published')
                            ->label('منشور')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('الصورة')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('comments_count')
                    ->counts('comments')
                    ->label('الردود')
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('تاريخ النشر')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('منشور')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('منشور'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
