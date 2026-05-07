# Documentation Overview （By ChatGPT)

Status: draft

This directory contains the design documentation for the CanonicalTextTrees system.

The goal of this documentation is not only to describe the system, but to define a stable conceptual framework that supports long-term development, data generation, and future extensions.

## CanonicalTextTrees 

CanonicalTextTrees is a framework for representing texts as canonical trees with stable paths, enabling precise text addressing, retrieval, transformation, and cross-text referencing.

The project was originally developed for classical Chinese texts (古籍), especially 杜甫詩歌與相關注本, but the underlying architecture is language-agnostic and has also been tested on:

- modern Chinese literature
- English prose
- French prose

The core idea is simple:

A text is first normalized and segmented into stable structural units, then represented as a tree whose terminal nodes can be addressed through explicit paths.

---

## Core Principles

1. Texts are represented as trees

A text is transformed into a canonical text tree.

Typical structures include:

<pre>
Document
└── Section / Chapter
    └── Paragraph / Line
        └── Sentence
            └── Terminal nodes</pre>

Terminal nodes depend on the language and preprocessing policy:

| **Language / Corpus**	| **Typical terminal node** |
| --------------------- | ------------------------- |
| 杜甫詩文				| Character （字）				|
| 古籍					| Segments （句）				|
| 杜著述（注、評等）			| Lines （行）					|
| Modern Chinese		| Character or word			|
| English				| Word/Sentence				|

Punctuation marks may also be represented as independent nodes.

2. Paths are stable addresses

Each terminal node can be addressed by a complete path.

Example:

〚LUNYU,01,1,3,2,4〛

Paths are:

explicit
complete
deterministic
language-independent

The system supports:

coordinate → text
text → coordinate
range addressing
scope-based retrieval
3. Scope is the semantic core

A scope is defined as:

an ordered set of valid paths

Coordinates and range coordinates are only representations of scope.

Example:

〚…,1-5〛

is treated as a compressed representation of:

{〚…,1〛, 〚…,2〛, 〚…,3〛, 〚…,4〛, 〚…,5〛}

The system distinguishes between:

dense scopes (compressible)
non-dense scopes (non-compressible)
4. Metadata is separated from text

Canonical texts remain stable and minimally modified.

Metadata is stored separately and attached through paths and scopes.

Examples include:

annotations
citations
cross-text references
textual corrections
recovered fragments
editorial notes

This separation allows:

multiple views
reversible transformations
traceable editorial intervention
preservation of source texts
Design Philosophy
Single Source of Truth

Textual content should exist in one place only.

Metadata should reference texts through paths rather than duplicate textual content whenever possible.

Structure First

The framework prioritizes:

stable structure
stable addressing
stable retrieval

Interpretation and presentation belong to higher layers.

Language-Agnostic Architecture

The framework is not tied to a specific language.

Different corpora may require different preprocessing and tokenization policies, but the tree architecture and path system remain unchanged.

Current Experimental Corpora

The framework has been tested on:

Classical Chinese
《論語》
《孟子》
《老子》
《詩經》
杜甫詩歌
《文選》 (ongoing)
Modern Chinese
《紅樓夢》前八十回
English
sample texts from Pride and Prejudice
sample texts from Project Hail Mary
French
small experimental samples
Typical Workflow
Raw text
    ↓
Normalization
    ↓
Segmentation
    ↓
Canonical tree generation
    ↓
Path generation
    ↓
Search / metadata / rendering
Possible Applications
Canonical text representation
Precise textual citation
Annotation systems
Commentary databases
Textual criticism
Cross-text quotation tracking
Fragment recovery
Literary analysis
Search and retrieval
Multi-version comparison
Repository Structure (draft)
CanonicalTextTrees/
├── docs/
├── corpora/
├── trees/
├── metadata/
├── tools/
└── tests/
Current Status

The framework is still under active development.

At present, the main focus is:

stabilizing the addressing system
refining scope semantics
generating reliable canonical trees
testing scalability across different textual genres

rather than building large-scale annotation datasets.

Long-Term Goal

The long-term goal of CanonicalTextTrees is to provide:

a stable structural foundation for representing, addressing, connecting, and studying texts across languages, editions, and traditions.