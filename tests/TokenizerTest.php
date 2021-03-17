<?php

/** @noinspection StaticClosureCanBeUsedInspection */

$tokenizer = new \Terpomoj\ArgsParser\Tokenizer();

it('handles unquoted string', function () use ($tokenizer) {
    $args = $tokenizer('--foo 99');
    expect($args[0])->toBe('--foo');
    expect($args[1])->toBe('99');
});

it('handles quoted string with no spaces', function () use ($tokenizer) {
    $args = $tokenizer("--foo 'hello'");
    expect($args[0])->toBe('--foo');
    expect($args[1])->toBe("'hello'");
});

it('handles single quoted string with spaces', function () use ($tokenizer) {
    $args = $tokenizer("--foo 'hello world' --bar='foo bar'");
    expect($args[0])->toBe('--foo');
    expect($args[1])->toBe("'hello world'");
    expect($args[2])->toBe("--bar='foo bar'");
});

it('handles double quoted string with spaces', function () use ($tokenizer) {
    $args = $tokenizer('--foo "hello world" --bar="foo bar"');
    expect($args[0])->toBe('--foo');
    expect($args[1])->toBe('"hello world"');
    expect($args[2])->toBe('--bar="foo bar"');
});

it('handles single quoted empty string', function () use ($tokenizer) {
    $args = $tokenizer('--foo \'\' --bar=\'\'');
    expect($args[0])->toBe('--foo');
    expect($args[1])->toBe("''");
    expect($args[2])->toBe("--bar=''");
});

it('handles double quoted empty string', function () use ($tokenizer) {
    $args = $tokenizer('--foo "" --bar=""');
    expect($args[0])->toBe('--foo');
    expect($args[1])->toBe('""');
    expect($args[2])->toBe('--bar=""');
});

it('handles quoted string with embedded quotes', function () use ($tokenizer) {
    $args = $tokenizer('--foo "hello \'world\'" --bar=\'foo "bar"\'');
    expect($args[0])->toBe('--foo');
    expect($args[1])->toBe('"hello \'world\'"');
    expect($args[2])->toBe('--bar=\'foo "bar"\'');
});

it('handles quoted string with embedded quotes using same quote', function () use ($tokenizer) {
    $args = $tokenizer('--foo "hello \\"world\\"" \'foo \\\'bar\\\'\'');
    expect($args[0])->toBe('--foo');
    expect($args[1])->toBe('"hello \\"world\\""');
    expect($args[2])->toBe("'foo \\'bar\\''");
});

// https://github.com/yargs/yargs-parser/pull/100
// https://github.com/yargs/yargs-parser/pull/106
it('ignores unneeded spaces', function () use ($tokenizer) {
    $args = $tokenizer('  foo  bar  "foo  bar"  ');
    expect($args[0])->toBe('foo');
    expect($args[1])->toBe('bar');
    expect($args[2])->toBe('"foo  bar"');
});

it('handles boolean options', function () use ($tokenizer) {
    $args = $tokenizer('--foo -bar');
    expect($args[0])->toBe('--foo');
    expect($args[1])->toBe('-bar');
});

it('handles empty string', function () use ($tokenizer) {
    $args = $tokenizer('');
    expect(count($args))->toBe(0);
});
