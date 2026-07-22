# Otimização das imagens de capa do blog

## Contexto

O PageSpeed Insights (desktop) apontou ~**417 KiB** de economia possível nas imagens
de capa dos artigos. O motivo: as capas são servidas em **1189×1024 px** e exibidas em
cards de apenas **270×180 px**. O navegador baixa a imagem cheia e descarta ~4× dos pixels.

## Por que isso NÃO se resolve editando os arquivos deste repositório

O bloco de artigos da home (`<div id="soro-blog">`) é **gerado em tempo de execução por
um embed de terceiros** — o Soro (`https://app.trysoro.com/api/embed/…`). O HTML dos
cards, as tags `<img>` e as URLs das imagens (no Supabase Storage) **não existem nos
arquivos do site**: são injetados pelo script do Soro no navegador do visitante.

Ou seja:

- Não há tags `<img>` no repositório para receber `srcset`/`sizes`/`width`/`height`.
- Não há pipeline de upload de imagem neste repositório — as capas são enviadas
  **dentro do editor do Soro**, não por código daqui.

Por isso a otimização é feita em **duas frentes**: uma mitigação automática (já aplicada)
e um processo manual recomendado (a causa-raiz).

---

## 1) Mitigação automática já aplicada (client-side)

Foi adicionado, logo após o embed do Soro em `index.html`, um pequeno script que roda
depois que os cards são injetados e:

- **Reduz cada capa** trocando a URL pública do Supabase
  (`/storage/v1/object/public/…`) pelo endpoint de transformação
  (`/storage/v1/render/image/public/…?width=600&height=400&resize=cover&quality=78`),
  entregando uma imagem ~600×400 em WebP em vez da original de 1189×1024.
- Adiciona `width`, `height`, `loading="lazy"` e `decoding="async"` para eliminar
  *layout shift* (CLS) e adiar o download.
- Se o **Supabase Image Transformation não estiver habilitado** no projeto, a imagem
  transformada falha e o script **restaura automaticamente a URL original** (`onerror`),
  sem quebrar o blog.

> **Requisito para essa mitigação funcionar de fato:** o recurso *Image Transformations*
> precisa estar ativo no projeto Supabase que hospeda as capas (planos pagos do Supabase).
> Se estiver desativado, o site continua funcionando, mas a economia **não** acontece —
> nesse caso, use o processo manual abaixo, que é a solução definitiva.

---

## 2) Processo manual recomendado (solução definitiva)

Redimensionar e comprimir as capas **antes de enviá-las** no editor do Soro. Isso resolve
o problema na origem e independe de qualquer recurso do Supabase.

**Alvo de exportação para cada capa:**

| Parâmetro           | Valor recomendado                          |
|---------------------|--------------------------------------------|
| Dimensão máxima     | **540×360 px** (2× o tamanho de exibição)  |
| Formato             | **WebP**                                   |
| Qualidade           | **75–80**                                  |
| Peso alvo por capa  | ~30–50 KB (vs. ~90–110 KB da original)     |

**Passo a passo:**

1. Antes de subir a capa no Soro, abra a imagem em um editor (Photopea, GIMP, Squoosh,
   Photoshop, etc.).
2. Redimensione para no máximo **540 px de largura** (mantendo a proporção) ou recorte
   para **540×360** (proporção 3:2, igual ao card).
3. Exporte em **WebP, qualidade 75–80**.
4. Faça o upload dessa versão otimizada no editor do Soro.

**Ferramentas rápidas:**

- [Squoosh](https://squoosh.app/) — arraste a imagem, escolha WebP, ajuste a qualidade e
  a largura no painel *Resize*, baixe.
- Linha de comando (ImageMagick):
  ```bash
  magick capa-original.jpg -resize 540x360^ -gravity center -extent 540x360 -quality 78 capa-otimizada.webp
  ```
- Linha de comando (cwebp):
  ```bash
  cwebp -q 78 -resize 540 0 capa-original.jpg -o capa-otimizada.webp
  ```

---

## Resumo

| Frente                         | Onde                         | Status                                   |
|--------------------------------|------------------------------|------------------------------------------|
| Mitigação client-side          | `index.html` (após o embed)  | ✅ aplicada (depende do transform ativo) |
| Upload de capas já otimizadas  | Editor do Soro (manual)      | ⏳ processo recomendado acima            |

A mitigação client-side dá o ganho automaticamente **se** o Supabase Image Transformation
estiver ativo. Independentemente disso, adotar o processo manual (item 2) garante capas
leves para todos os visitantes e é a recomendação principal.
