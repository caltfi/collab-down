<h1 class="text-center mt-2">Markdown Cheat Sheet</h1>
    <hr>
    <p>This Markdown cheat-sheet gives a brief overview of all the wonderful parts of Markdown syntax. If you are having trouble, refer to the information below, however, if you are interested in learning some more advanced and complicated aspects to Markdown to improve your document (or just for fun!) then <a href="https://github.github.com/gfm/" class="text-body">follow this link</a> to find out more.</p>
    
    <h2>Headers</h2>
    <p>Here are some examples of headers in Markdown:</p>
    <ul class="list-group">
        <li class="list-group-item"><h1>Heading 1</h1><section># Heading 1</section></li>
        <li class="list-group-item"><h2>Heading 2</h2><section>## Heading 2</section></li>
        <li class="list-group-item"><h3>Heading 3</h3><section>### Heading 3</section></li>
        <li class="list-group-item"><h4>Heading 4</h4><section>#### Heading 4</section></li>
        <li class="list-group-item"><h5>Heading 5</h5><section>##### Heading 5</section></li>
        <li class="list-group-item"><h6>Heading 6</h6><section>###### Heading 6</section></li>
    </ul>
    
    <h2>Emphasis</h2>
    <p>Here are some ways to add emphasis to text:</p>
    <ul class="list-group">
        <li class="list-group-item"><em>italic</em><section>*italic* or _italic_</section></li>
        <li class="list-group-item"><strong>bold</strong><section>**bold** or __bold__</section></li>
        <li class="list-group-item"><del>strikethrough</del><section>~~strikethrough~~</section></li>
    </ul>

    <h2>Lists</h2>
    <p>Here is how to create both ordered and unordered lists:</p>
    <ul class="list-group">
        <li class="list-group-item">
            <section>
                <ol>
                    <li>Item A</li>
                    <li>Item B</li>
                    <li>Item C</li>
                </ol>
            </section><pre>
    Ordered List:
    1. Item A
    2. Item B
    3. Item C
    </pre>
        </li>
        <li class="list-group-item">
            <section >
                <ul>
                    <li>Item 1</li>
                    <li>Item 2</li>
                    <li>Item 3</li>
                </ul>
            </section><pre>
    Unordered List:
    - Item 1
    - Item 2
    - Item 3
    </pre>
        </li>
    </ul>


    
    <h2>Links</h2>
    <p>How to insert links in your text:</p>
    <ul class="list-group">
        <li class="list-group-item"><section><a href="#">Link Text</a></section><br><pre>[Link Text](http://example.com)</pre></li>
    </ul>
    
    <h2>Images</h2>
    <p>Here is how to place images:</p>
    <ul class="list-group">
        <li class="list-group-item"><section><img src="assets/images/rubber_duck.png" style="width: 120px; height: 120px; margin-left: 100px;" alt="Alt Text"></section><br><pre>![Alt Text](rubber-duck.jpg)</pre></li>
    </ul>
    
    <h2>Blockquotes</h2>
    <p>What if you want blockquotes?:</p>
    <ul class="list-group">
        <li class="list-group-item"><blockquote><p>This is a blockquote.</p></blockquote><pre></pre>> This is a blockquote.</li>
    </ul>

    <h2>Code Blocks</h2>
    <p>If you need to include blocks of code in your document, use the backtick (`) symbol:</p>
    <ul class="list-group">
        <li class="list-group-item"><code>code</code><pre>Inline code: \`code\`</pre></li>
        <li class="list-group-item"><pre><code class="language-python">def hello():
    print("Hello, World!")
</code></pre><pre>\```python
def hello():
    print("Hello, World!")
\```</pre></li>
    </ul>
    
    <h2>Horizontal Rule</h2>
    <p>This is how to insert a horizontal line break into your text:</p>
    <ul class="list-group">
        <li class="list-group-item">
            <hr class="border-3"><br>
        <pre>
---
    </pre>
        </li>
    </ul>

    
    <h2>Tables</h2>
    <p>Need a table? No problem:</p>
    <ul class="list-group">
        <li class="list-group-item">
            <table class="table border border-2">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Header 1</th>
                        <th scope="col">Header 2</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Cell 1</td>
                        <td>Cell 2</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Cell 3</td>
                        <td>Cell 4</td>
                    </tr>
                </tbody>
            </table><br>
        <pre>
| #        | Header 1 | Header 2 |
|----------|----------|----------|
| 1        | Cell 1   | Cell 2   |
| 2        | Cell 3   | Cell 4   |
    </pre>
        </li>
    </ul>

    
    <h2>Task Lists</h2>
    <p>Here is how you can create task lists and check off items in the list:</p>
    <ul class="list-group">
        <li class="list-group-item">
            <ul>
                <li><input type="checkbox" checked> Task 1</li>
                <li><input type="checkbox"> Task 2</li>
                <li><input type="checkbox"> Task 3</li>
            </ul>
    <br><pre>
- [x] Task 1
- [ ] Task 2
- [ ] Task 3
    </pre></li>
    </ul>